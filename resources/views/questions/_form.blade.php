@csrf
<div class="form-group">
    <label for="question-title">Question Title</label>
    <input type="text" name="title" id="question-title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" value="{{ old('title', $question->title) }}"><!-- oldの第二引数でデフォルト値を設定できる -->
    @if($errors->has('title'))
    <div class="invalid-feedback">
        <strong>{{ $errors->first('title') }}</strong>
    </div>
    @endif
</div>
<div class="form-group">
    <label for="question-body">Explain your question</label>
    <textarea name="body" id="question-body" class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}" cols="10" rows="10">{{ old('body', $question->body) }}</textarea>
    @if($errors->has('body'))
    <div class="invalid-feedback">
        <strong>{{ $errors->first('body') }}</strong>
    </div>
    @endif
</div>
<div class="form-group">
    <button class="btn btn-outline-primary btn-lg" type="submit">{{ $buttonText }}</button>
</div>
