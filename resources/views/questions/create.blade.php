@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h2>Ask Question</h2>
                        <div class="ml-auto">
                            <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Back to all Questions</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('questions.store') }}" method="post">
                        <div class="form-group">
                            <label for="question-title">Question Title</label>
                            <input type="text" name="title" id="question-title" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="question-body">Explain your question</label>
                            <textarea name="body" id="question-body" class="form-control" cols="10" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-outline-primary btn-lg" type="submit">Ask this question</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
