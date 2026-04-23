<section class="section"><div class="container"><h1>Application #<?= e($application['id']); ?></h1>
<?php if ($error = flash('error')): ?><div class="alert alert-error"><?= e($error); ?></div><?php endif; ?>
<div class="detail-grid">
<?php foreach ($application as $k => $v): ?><div><strong><?= e(ucwords(str_replace('_',' ',$k))); ?></strong><p><?= e((string) $v); ?></p></div><?php endforeach; ?>
</div>
<form method="post" action="/admin/applications/status" class="filters"><?= csrf_field(); ?>
<input type="hidden" name="id" value="<?= e($application['id']); ?>">
<select name="status"><?php foreach (['New','Reviewing','Qualified','Not Qualified','Contacted'] as $s): ?><option <?= $application['status']===$s?'selected':''; ?>><?= e($s); ?></option><?php endforeach; ?></select>
<button class="btn btn-small" type="submit">Update Status</button>
</form>
<p><a href="/admin/dashboard">Back to dashboard</a></p></div></section>
