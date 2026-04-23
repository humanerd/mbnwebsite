<section class="section"><div class="container narrow"><h1>Admin Login</h1>
<?php if ($error = flash('error')): ?><div class="alert alert-error"><?= e($error); ?></div><?php endif; ?>
<form method="post" action="/admin/login" class="form-grid"><?= csrf_field(); ?>
<label>Email<input type="email" name="email" required></label>
<label>Password<input type="password" name="password" required></label>
<button class="btn" type="submit">Sign In</button>
</form></div></section>
