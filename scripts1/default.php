<div>
  <h1>Pagina por defecto</h1>
</div>

<div class="jumbotron text-center container">
	<h3>Login Modal</h3>
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginModal">Acceso</button>
</div>

<div class="modal" role="dialog" id="loginModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">Modal login</h3>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<div class="modal-body">
				<div class="form-group">
					<input type="text" name="username" class="form-control" placeholder="Username">
				</div>
				<div class="form-group">
					<input type="password" name="password" class="form-control" placeholder="Password">
				</div>
			</div>

			<div class="modal-footer">
				<button type="submit" class="btn btn-success">Acceso</button>
			</div>
		</div>
	</div>
</div>
