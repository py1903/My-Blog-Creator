@extends('template')

@section('header')

@section('nav')
    <ul class="nav navbar-nav {{ !Auth::check()? 'hidden' : '' }}">
    	<li>{!! link_to_route('post.create', 'Créer un article') !!}</li>
		<li>{!! link_to('#', 'Deconnexion', ['id' => 'logout']) !!}</li>
	</ul>
	{!! Form::open(['id' => 'postLogin', 'url' => 'auth/login', 'class' => 'navbar-form navbar-right'.(Auth::check()? ' hidden' : '')]) !!}
		<div class="form-group">
			{!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
		</div>
		<div class="form-group">
			{!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Mot de passe']) !!}
		</div>		
		{!! Form::submit('Connexion', ['class' => 'btn btn-default']) !!}
		<div class="checkbox">
			<label>
				{!! Form::checkbox('remember') !!} Se rappeler de moi
			</label>
		</div>
	{!! Form::close() !!}
@stop

@section('contenu')
	@if(isset($info))
		<div class="row alert alert-info">{{ $info }}</div>
	@endif
	{!! $links !!}
	@foreach($posts as $post)
		<article class="row bg-primary">
			<div class="col-md-12">
				<header>
					<h1>{{ $post->titre }}
						<div class="pull-right">
							@foreach($post->tags as $tag)
								{!! link_to('post/tag/' . $tag->tag_url, $tag->tag,	['class' => 'btn btn-xs btn-info']) !!}
							@endforeach
						</div>
					</h1>
				</header>
				<hr>
				<section>
					<p>{{ $post->contenu }}</p>
					{!! Form::open(['id' => 'del', 'method' => 'DELETE', 'route' => ['post.destroy', $post->id], 'class' => !(Auth::check() and Auth::user()->admin)? 'hidden' : '']) !!}
						{!! Form::submit('Supprimer cet article', ['class' => 'btn btn-danger btn-xs ', 'onclick' => 'return confirm(\'Vraiment supprimer cet article ?\')']) !!}
					{!! Form::close() !!}
					<em class="pull-right">
						<span class="glyphicon glyphicon-pencil"></span> {{ $post->user->name }} le {!! $post->created_at !!}
					</em>
				</section>
			</div>
		</article>
		<br>
	@endforeach
	{!! $links !!}
@stop

@section('scripts')
	<script>
		$(function(){

			var password = $("input[name='password']").parent();
			var email = $("input[name='email']").parent();

			$('form#postLogin').submit(function(e) {
				e.preventDefault();
				password.removeClass('has-error');	
				email.removeClass('has-error');	
				$.post('{!! url('auth/login') !!}', $(this).serialize())
				.done(function(data) {
					if(data.ok) {
						$('ul.nav').removeClass('hidden');
						$('form#postLogin').addClass('hidden');
						if(data.ok == 'admin') $('form#del').removeClass('hidden');
					} else if(data.require) {
						if(data.require.password)
							password.addClass('has-error');	
						if(data.require.email) 
							email.addClass('has-error');
					} else if(data.response == 'fail') {
						password.addClass('has-error');	
						email.addClass('has-error');
					}
				});
			});

			$('#logout').click(function() {
				$.get('{!! url('auth/logout') !!}', function(data) {	
					if(data.response == 'logout') {
						$('ul.nav').addClass('hidden');
						$('form#postLogin').removeClass('hidden');
						$('form#del').addClass('hidden');
					}
				});		
			});

		});
	</script>
@stop