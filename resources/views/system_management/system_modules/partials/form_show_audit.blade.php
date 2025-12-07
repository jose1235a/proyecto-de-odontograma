<p>
  <strong><i class="fas fa-user"></i> {{ __('global.created_by') }}:</strong>
  {{ $system_module->creator->name ?? '-' }}
</p>

<p>
  <strong><i class="fas fa-calendar-plus"></i> {{ __('global.created_at') }}:</strong>
  {{ formatDateTime($system_module->created_at) }}
</p>

@if ($system_module->trashed())
<hr>
<p>
  <strong><i class="fas fa-user-slash"></i> {{ __('global.deleted_by') }}:</strong>
  {{ $system_module->deleter->name ?? '-' }}
</p>

<p>
  <strong><i class="fas fa-calendar-times"></i> {{ __('global.deleted_at') }}:</strong>
  {{ formatDateTime($system_module->deleted_at) }}
</p>

<p>
  <strong><i class="fas fa-comment-alt"></i> {{ __('global.deleted_reason') }}:</strong>
  {{ $system_module->deleted_description ?? '-' }}
</p>
@endif