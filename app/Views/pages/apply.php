<?php partial('components/hero', ['title' => 'Apply / Start a Conversation', 'description' => 'This is an operator qualification application for a standardized issuance model.']); ?>
<section class="section"><div class="container narrow">
<?php if ($error = flash('error')): ?><div class="alert alert-error"><?= e($error); ?></div><?php endif; ?>
<form method="post" action="/apply" class="form-grid" novalidate>
<?= csrf_field(); ?>
<input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">
<label>Full name<input required name="full_name" value="<?= e((string) old('full_name')); ?>"></label>
<label>Email<input required type="email" name="email" value="<?= e((string) old('email')); ?>"></label>
<label>Phone<input required name="phone" value="<?= e((string) old('phone')); ?>"></label>
<label>City / State<input required name="city_state" value="<?= e((string) old('city_state')); ?>"></label>
<label>Desired business type
<select name="desired_business_type" required>
<option value="">Select</option><option <?= old('desired_business_type')==='Mobile Body Sculpting & Wellness'?'selected':''; ?>>Mobile Body Sculpting & Wellness</option><option <?= old('desired_business_type')==='Mobile Pet Grooming'?'selected':''; ?>>Mobile Pet Grooming</option>
</select></label>
<label>Estimated available capital<input required name="available_capital" value="<?= e((string) old('available_capital')); ?>" placeholder="$150,000"></label>
<label>Financing needed?
<select name="financing_needed" required><option value="">Select</option><option <?= old('financing_needed')==='Yes'?'selected':''; ?>>Yes</option><option <?= old('financing_needed')==='No'?'selected':''; ?>>No</option></select>
</label>
<label>Relevant experience<textarea required name="relevant_experience"><?= e((string) old('relevant_experience')); ?></textarea></label>
<label>Intended timeline to launch<input required name="timeline_to_launch" value="<?= e((string) old('timeline_to_launch')); ?>" placeholder="3-6 months"></label>
<label>Why this business type<textarea required name="business_reason"><?= e((string) old('business_reason')); ?></textarea></label>
<label class="check"><input type="checkbox" name="agreement_acknowledged" value="1" <?= old('agreement_acknowledged')?'checked':''; ?>> I acknowledge this is a standardized issuance model, not a custom build.</label>
<button class="btn" type="submit">Submit Application</button>
</form></div></section>
