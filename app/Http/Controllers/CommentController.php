<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;
use Exception, Auth, Log;

class CommentController extends Controller {

    public function __construct(CommentRepository $commentRepo) 
    {
        $this->commentRepo = $commentRepo;
    }

    public function store(Tutorial $tutorial, Request $request)
    {
        $request->validate([
            'parent_id' => 'nullable | numeric', // Set if user replies to a comment
            'text' => 'required | max:500'
        ]);

        $status = 'success';
        $msg = 'Added comment successfully.';

        try {
            $this->commentRepo->create([
                'parent_id' => $request->parent_id,
                'user_id' => Auth::user()->id,
                'tutorial_id' => $tutorial->id,
                'text' => $request->text
            ]);
        } 
        catch(Exception $e) {
            Log::error($e);

            $status = 'error';
            $msg = 'Failed commenting.';
        }

        return redirect()->back()->with([$status => $msg]);
    }
}