<!-- Simplicity is the ultimate sophistication. - Leonardo da Vinci -->

<li>
    <label class="list-group-item dropdown-item">
        <input class="form-check-input me-1" type="checkbox" value="">
        @if ($type !== 'admin')
            <span class="badge bg-label-{{ $badge }}">{{ $label }}</span>
        @else
            {{ $label }}
        @endif
    </label>
</li>
