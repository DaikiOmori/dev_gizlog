@extends ('common.user')
@section ('content')

<h2 class="brand-header">日報作成</h2>
<div class="main-wrap">
  <div class="container">
    {!! Form::open(['route' => 'daily_report.store', 'method' => 'post']) !!}
      <input class="form-control" name="user_id" type="hidden">
    <div class="form-group form-size-small">
      <input class="form-control" name="reporting_time" type="date">
      <span class="help-block">{{ $errors->first('reporting_time') }}</span>
    </div>
    <div class="form-group">
      <input class="form-control" placeholder="Title" name="title" type="text">
      <span class="help-block">{{ $errors->first('title') }}</span>
    </div>
    <div class="form-group">
      <textarea class="form-control" placeholder="Content" name="contents" cols="50" rows="10"></textarea>
      <span class="help-block"></span>
    </div>
      {!! Form::submit('ADD', ['name' => 'ADD', 'class' => 'btn btn-success pull-right']) !!}
    {!! Form::close() !!}
  </div>
</div>
@endsection

