@extends('layout')

@section('content')
<style>
	.uper {
		margin-top: 40px;
	}
 	html, body {
		background-color: #fff;
	    color: #636b6f;
	    font-family: 'Nunito', sans-serif;
	    font-weight: 200;
	    height: 100vh;
	    margin: 0;
	}
	.title {
		font-size: 36px;
		text-align: center;
		padding: 5px;
		align-items: center;
        display: flex;
        justify-content: center;
	}
	.card-header {
		height: 60px;
	}
</style>

<div class="row title">
	Hello World!
</div>
<div class="row">
	<div class="col-sm-4">
		<div class="card">
		  	<div class="card-header">
		    	{{ isset($sel) ? 'Edit Task #'.$sel->id : 'Add' }} 
		    	<a href="{{ route('tasks.index')}}" class="btn btn-primary btn-sm float-right">New Task</a>
		  	</div>
		  	<div class="card-body">
			    @if ($errors->any())
			      <div class="alert alert-danger">
			        <ul>
			            @foreach ($errors->all() as $error)
			              <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			      </div><br />
			    @endif
		      	<form method="post" action="{{ route('tasks.store') }}">
					<div class="form-group">
						@csrf
						<label for="name">Task Name:</label>
						<input type="text" class="form-control" name="name" value="{{ isset($sel)? $sel->name : '' }}"/>
					</div>
					<div class="form-group">
						@csrf
						<label for="name">Task Description:</label>
						<textarea class="form-control" name="desc">{{ isset($sel)? $sel->desc : '' }}</textarea>
					</div>
					@if(isset($sel))
		          		<button type="submit" class="btn btn-warning btn-sm">Save</button>
		          	@endif
		     	</form>
			</div>
		</div>
	</div>
	<div class="col-sm-8">
		<div class="card">
			<div class="card-header">
		    	Task lists
		    	<button type="submit" class="btn btn-sm btn-success float-right">Generate XML</button>
		  	</div>
		  	<div class="card-body">
		  		<table class="table">
		  			<tr>
			  			<td>Name</td>
			  			<td>Description</td>
			  			<td> </td>
		  			</tr>
		  			<tr>
		  				@foreach($tasks as $task)
		  					<tr>
			  					<td>{{$task->name}}</td>
			  					<td>{{$task->desc}}</td>
			  					<td>
					                <form action="{{ route('tasks.destroy', $task->id)}}" method="post">
				  						<a href="{{ route('tasks.edit',$task->id)}}" class="btn btn-primary btn-sm">
				  							<i class="fa fa-edit"></i>
				  						</a>
					                  @csrf
					                  @method('DELETE')
					                  <button class="btn btn-danger btn-sm" type="submit"><i class="fa fa-remove"></i></button>
					                </form>
					            </td>
				        	</tr>
		  				@endforeach
		  			</tr>
		  		</table>
		  	</div>
		</div>
		<br>
		<div class="card">
			<div class="card-header">
		    	XML Generated
		  	</div>
		  	<div class="card-body">
		  		<textarea class="form-control" readonly>{{$task}}</textarea>
		  	</div>
		</div>
	</div>
</div>
@endsection