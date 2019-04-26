@extends ('common.user')
@section ('content')

<h1 class="brand-header">日報編集</h1>
<div class="main-wrap">
  <div class="container">
    {!! Form::open(['route' => ['daily_report.update', $dailyreport->id], 'method' => 'put']) !!}
      <input class="form-control" name="user_id" type="hidden" value="4">
      <div class="form-group form-size-small">
        <input class="form-control" name="reporting_time" value="{{ $dailyreport->reporting_time }}">
      <span class="help-block"></span>
      </div>
      <div class="form-group">
        <input class="form-control" name="title" type="text" value="{{ $dailyreport->title }}">
      <span class="help-block">{{ $errors->first('title') }}</span>
      </div>
      <div class="form-group">
        <textarea class="form-control" placeholder="本文です" name="contents" cols="50" rows="10">{{ $dailyreport->contents }}</textarea>
      <span class="help-block"></span>
      </div>
    {!! Form::submit('UPDATE', ['name' => 'UPDATE', 'class' => 'btn btn-success pull-right']) !!}
    {!! Form::close() !!}
  </div>
</div>

@endsection

