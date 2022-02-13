<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Propaganistas\LaravelFakeId\RoutesWithFakeIds;

class User extends Authenticatable
{
    use Notifiable;
    use RoutesWithFakeIds;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function socialLogin()
    {
        return $this->belongsTo('App\SocialLogin');
    }

    public function purchases()
    {
        return $this->hasMany('App\UserPurchase');
    }

    // Needed for access to the fake ID.
    public function getFakeIdAttribute()
    {
        return $this->getRouteKey();
    }

    public static function getUserByEmail($email, array $relations)
    {
        return User::with($relations)->where('email','=',$email)->first();
    }

    public function isAdmin() {
        return $this->is_admin;
    }

    public function getWrappingFolderName() {
        $userFakeId = $this->fake_id . '';

        // Fill with 0 if the index is not set
        $firstSymbol = $userFakeId[0] ?? '0';
        $secondSymbol = $userFakeId[1] ?? '0';

        return 'users-progress/' . $firstSymbol . $secondSymbol;
    }

    public function getDataFilePath() {
        $userFakeId = $this->fake_id . '';

        $thirdSymbol = $userFakeId[2] ?? '0';
        $forthSymbol = $userFakeId[3] ?? '0';
        $fifthSymbol = $userFakeId[4] ?? '0';

        return $this->getWrappingFolderName() . '/' . $thirdSymbol . $forthSymbol . $fifthSymbol . '.json';
    }

    public function getProgress() {
        $path = $this->getDataFilePath();

        if(Storage::exists($path)) {
            $dataObj = json_decode(Storage::get($path));
            
            if(isset($dataObj->{$this->fake_id})) {
                // Data of the progress for the user exists.
                return json_encode($dataObj->{$this->fake_id});
            }

            // The file of the user (like 345.json) exists but no records for this user.
        }

        return false;
    }

    public static function generateUniqueUsername($email) {
        $i = 0;

        $firstPart = explode("@", $email)[0];
        $username = $firstPart;

        while(User::where('username', $username)->exists())
        {
            $i++;
            $username = $firstPart . $i;
        }

        return $username;
    }

    public static function getEmptyProgress() {
        // Must follow the structure of the user progress file.

        $progress = (object)[];
        $progress->langProgress = (object) [];

        foreach(config('techEntities') as $techEntity) {

            $progress->langProgress->{$techEntity} = self::getLangEmptyProgress();
        }

        $progress->robotBattles = (object) [];

        foreach(config('categories') as $cat) {
            $progress->robotBattles->{$cat} = (object) [
                'Easy' => 0,
                'Medium' => 0,
                'Hard' => 0
            ];
        }

        $progress->projects = [];
        $progress->interviewQuestions = [];
        $progress->challenges = [];


        $progress->coins = 0;
        $progress->wins = 0;
        $progress->loses = 0;

        return $progress;
    }

    public static function getLangEmptyProgress() {
        return (object) [
            'examGrades' => (object) [],
            'puzzles' => [],
            'tests' => (object) []
        ];
    }

    // appendsChanges is true when only changes are sent to the server (automatic changes upload)
    // appendsChanges is false when all of the progress is uploaded (clicking the cloud sync button by the user).
    public static function mergeChangesIntoUserProgress(&$userProgress, $changes, $appendsChanges) {

        // It's possible changes to be empty array if user starts app and no changes have ever been made during app usage from the device. 
        // So we simply don't merge any changes into the userProgress.
        if(count((array)$changes) === 0) {
            return;
        }

        // Languages Progress:
        foreach(config('techEntities') as $techEntity) {

            $langProgress = $userProgress->langProgress->{$techEntity};
            $changesLangProgress = $changes->langProgress->{$techEntity};

            // Puzzles
            // array_values reindex arrays. Array like [0 => 11111, 2 => 7777, 3 => 999] is parsed as JSON object instead of array.
            $userProgress->langProgress->{$techEntity}->puzzles = array_values(array_unique(array_merge($changesLangProgress->puzzles, $langProgress->puzzles))); 
        
            // Tests
            $userProgressTests = $langProgress->tests;

            foreach($changesLangProgress->tests as $testId => $value) {
                // Not existing key or existing but with less value.
                if(!isset($userProgressTests->{$testId}) ||
                    $userProgressTests->{$testId} < $value ) {
                    $userProgressTests->{$testId} = $value;
                }
            }

            $userProgress->langProgress->{$techEntity}->tests = (count((array)$userProgressTests) === 0) ? (object)[] : $userProgressTests;

            // Exam Grades:
            $userProgressExamGrades = $langProgress->examGrades;

            foreach($changesLangProgress->examGrades as $category => $grade) {
                // Not existing key or existing but with less value.
                if(!isset($userProgressExamGrades->{$category}) ||
                strcmp($userProgressExamGrades->{$category}, $grade) > 0) {

                    $userProgressExamGrades->{$category} = $grade;
                }
            }

            // (object) is used so it's parsed as {} instead of [].
            $userProgress->langProgress->{$techEntity}->examGrades = (count((array)$userProgressExamGrades) === 0) ? (object)[] : $userProgressExamGrades;
        }

        // Robot Battles
        $userProgressRobotBattles = $userProgress->robotBattles;

        foreach($changes->robotBattles as $category => $difficultyWins) {
            
            $userProgressRobotBattlesCategoryData = $userProgressRobotBattles->{$category};
            
            foreach($difficultyWins as $difficulty => $wins) {
                
                if($appendsChanges) {
                    $userProgressRobotBattles->{$category}->{$difficulty} += $wins;
                }
                else {
                    // if previous robot battles wins are less  than the passed:
                    if($userProgressRobotBattlesCategoryData->{$difficulty} < $wins) {
                        $userProgressRobotBattles->{$category}->{$difficulty} = $wins;
                    }
                }
            }
        }

        $userProgress->robotBattles = $userProgressRobotBattles;

        // Projects, Challenges
        // array_values reindex arrays. Array like [0 => 11111, 2 => 7777, 3 => 999] is parsed as JSON object instead of array.
        $userProgress->projects = array_values(array_unique(array_merge($changes->projects, $userProgress->projects)));
        $userProgress->challenges = array_values(array_unique(array_merge($changes->challenges, $userProgress->challenges)));

        // TODO: Interview questions, pvp wins, pvp loses.
        // Tip: for pvp wins/loses you'll need to take into account $appendsChanges.
        
        if($appendsChanges) $userProgress->coins += $changes->coins; // Keep in mind that coins may decrease.
    }
}
