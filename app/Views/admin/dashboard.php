<section class="section"><div class="container"><h1>Application Dashboard</h1>
<?php if ($success = flash('success')): ?><div class="alert alert-success"><?= e($success); ?></div><?php endif; ?>
<form method="get" action="/admin/dashboard" class="filters">
<input name="q" value="<?= e($filters['query']); ?>" placeholder="Search name/email/phone">
<select name="business"><option value="">All businesses</option><option <?= $filters['business']==='Mobile Body Sculpting & Wellness'?'selected':''; ?>>Mobile Body Sculpting & Wellness</option><option <?= $filters['business']==='Mobile Pet Grooming'?'selected':''; ?>>Mobile Pet Grooming</option></select>
<select name="status"><?php foreach (['','New','Reviewing','Qualified','Not Qualified','Contacted'] as $s): ?><option value="<?= e($s); ?>" <?= $filters['status']===$s?'selected':''; ?>><?= e($s===''?'All statuses':$s); ?></option><?php endforeach; ?></select>
<button class="btn btn-small" type="submit">Filter</button></form>
<table><thead><tr><th>ID</th><th>Name</th><th>Business</th><th>Status</th><th>Submitted</th><th></th></tr></thead><tbody>
<?php foreach ($applications as $app): ?><tr><td><?= e($app['id']); ?></td><td><?= e($app['full_name']); ?></td><td><?= e($app['desired_business_type']); ?></td><td><?= e($app['status']); ?></td><td><?= e($app['created_at']); ?></td><td><a href="/admin/applications/view?id=<?= e($app['id']); ?>">View</a></td></tr><?php endforeach; ?>
</tbody></table>
<form method="post" action="/admin/logout" class="mt"><?= csrf_field(); ?><button class="btn btn-outline btn-small" type="submit">Logout</button></form>
</div></section>
