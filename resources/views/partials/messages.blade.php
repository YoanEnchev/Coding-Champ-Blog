@if(session('info'))
  @include('partials.alert', [
    'text' => session('info'),
    'color'=> 'primary'
  ])
@endif

@if(session('success'))
  @include('partials.alert', [
    'text' => session('success'),
    'color'=> 'primary'
  ])
@endif

@if(session('warning'))
  @include('partials.alert', [
    'text' => session('warning'),
    'color'=> 'warning'
  ])
@endif

@if(session('error'))
  @include('partials.alert', [
    'text' => session('error'),
    'color'=> 'danger'
  ])
@endif