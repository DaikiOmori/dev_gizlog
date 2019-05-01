@extends ('common.user')
@section ('content')

<h1 class="brand-header">日報編集</h1>
<div class="main-wrap">
  <div class="container">
    {!! Form::open(['route' => ['daily_report.update', $dailyreport->id], 'method' => 'put']) !!}
      <input class="form-control" name="user_id" type="hidden" value="{{ $dailyreport->user_id }}">
      <div class="form-group form-size-small {{ $errors->has('reporting_time')? 'has-error' : '' }}">
        <input class="form-control" name="reporting_time" type="date" value="{{ $dailyreport->reporting_time->format('Y-m-d') }}">
      <span class="help-block">{{ $errors->first('reporting_time') }}</span>
      </div>
      <div class="form-group {{ $errors->has('title')? 'has-error' : '' }}">
        <input class="form-control" placeholder="Title" name="title" type="text" value="{{ $dailyreport->title }}">
      <span class="help-block">{{ $errors->first('title') }}</span>
      </div>
      <div class="form-group {{ $errors->has('contents')? 'has-error' : '' }}">
        <textarea class="form-control" placeholder="Content" name="contents" cols="50" rows="10">{{ $dailyreport->contents }}</textarea>
      <span class="help-block">{{ $errors->first('contents') }}</span>
      </div>
    {!! Form::submit('UPDATE', ['name' => 'UPDATE', 'class' => 'btn btn-success pull-right']) !!}
    {!! Form::close() !!}
  </div>
</div>

@endsection

