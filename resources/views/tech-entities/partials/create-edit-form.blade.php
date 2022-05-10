<form method="POST" action="{{ $url }}">
    <div class="form-group mb-3">
        <label for="pretty-name">Pretty Name</label>
        <input class="form-control" id="pretty-name" name="pretty_name" maxlength="50" required
            {{--session('error') is set only if error is set in session without specifying field.
            Example: withError('Some string message.') --}}
            @if(($errors->any() || session('error')) && !!old('pretty_name')) value="{{ old('pretty_name') }}"
            @elseif(isset($techEntity)) value="{{ $techEntity->pretty_name }}"
            @endif
        >
    
        @if ($errors->has('pretty_name'))
            <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $errors->first('pretty_name') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group mb-3">
        <label for="url-name">Url Name</label>
        <input class="form-control" id="url-name" name="url_name" maxlength="50" required
            @if(($errors->any() || session('error')) && old('url_name')) value="{{ old('url_name') }}"
            @elseif(isset($techEntity)) value="{{ $techEntity->url_name }}"
            @endif
        >
    
        @if ($errors->has('url_name'))
            <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $errors->first('url_name') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group mb-3">
        <label for="cm-mode">Codemirror Mode</label>
        <input class="form-control" id="cm-mode" name="cm_mode" maxlength="50" required 
            @if(($errors->any() || session('error')) && old('cm_mode')) value="{{ old('cm_mode') }}"
            @elseif(isset($techEntity)) value="{{ $techEntity->cm_mode }}"
            @endif
        >
        
        @if ($errors->has('cm_mode'))
            <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $errors->first('cm_mode') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group mb-3">
        <label for="priority">Priority</label>
        <input class="form-control" id="priority" name="priority" required type="number"
            @if(($errors->any() || session('error')) && old('priority')) value="{{ old('priority') }}"
            @elseif(isset($techEntity)) value="{{ $techEntity->priority }}"
            @endif
        >
        
        @if ($errors->has('priority'))
            <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $errors->first('priority') }}</strong>
            </span>
        @endif
    </div>

    <button class="btn btn-primary" type="submit">{{ $btnText }}</button>

    @if($isEdit) {{ method_field('PUT') }} @endif
    
    @csrf
</form>