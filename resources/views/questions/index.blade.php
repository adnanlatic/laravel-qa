@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  <div class="d-flex align-items-center">
                    <h2>All questions</h2>
                    <div class="ml-auto">
                      <a href="{{ route('questions.create') }}" class="btn btn-outline-secondary">Ask question</a>
                    </div>
                  </div>

                </div>

                <div class="card-body">
                  @include('layouts._messages')
                   @foreach($questions as $question)
                      <div class="media">
                        <div class="d-flex flex-column counters">
                          <div class="vote">
                            <strong>{{ $question->votes_count }}</strong> {{ Str::of('votes')->plural() }}
                          </div>
                          <div class="status {{ $question->status }}">
                            <strong>{{ $question->answers_count }}</strong> {{ Str::of('answers')->plural() }}
                          </div>
                          <div class="view">
                            {{ $question->views .' '. Str::of('views')->plural() }}
                          </div>
                        </div>
                        <div class="media-body">
                          <div class="d-flex align-items-center">
                            <h3 class="mt-0"> <a href="{{ $question->url }}">{{ $question->title }}</a></h3>
                            <div class="ml-auto">
                              @can('update',$question)
                                <a href="{{ route('questions.edit',$question->id) }}" class="btn btn-sm btn-outline-info">Edit</a>
                              @endif
                              @can('delete',$question)
                                <form class="form-delete" action="{{ route('questions.destroy',$question->id) }}" method="post">
                                  @method('DELETE')
                                  @csrf
                                  <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')" name="button">Delete</button>
                                </form>
                                @endif
                            </div>
                          </div>

                            <p class="lead">
                              Asked by <a href="{{  $question->user->url }}">{{ $question->user->name }}</a>
                              <small class="text-muted">{{ $question->created_date }}</small>
                            </p>
                            {{ Str::limit($question->body, 250) }}
                        </div>
                      </div>
                      <hr>
                   @endforeach
                   <div class="text-center">
                     {{$questions->links()}}
                   </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
