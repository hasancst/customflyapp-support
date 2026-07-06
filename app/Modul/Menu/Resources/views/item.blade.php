<div class="menu-item-wrapper" data-id="{{ $item->id }}" style="background: #fff; padding: 15px; border: 1px solid var(--border); border-radius: 10px; margin-bottom: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-grip-vertical" style="color: #cbd5e1; cursor: move;"></i>
            <span style="font-weight: 600;">{{ $item->label }}</span>
            <code style="font-size: 0.75rem; background: #f1f5f9; padding: 2px 6px; border-radius: 4px; color: #64748b;">{{ $item->url }}</code>
        </div>
        <div style="display: flex; gap: 8px;">
            <button type="button" onclick="editMenu(this)" 
                data-id="{{ $item->id }}"
                data-label="{{ $item->label }}"
                data-url="{{ $item->url }}"
                data-parent="{{ $item->parent_id }}"
                data-target="{{ $item->target }}"
                data-posisi="{{ $item->posisi }}"
                style="background: #f1f5f9; border: none; padding: 5px 10px; border-radius: 6px; color: var(--primary); cursor: pointer;">
                <i class="fas fa-edit"></i>
            </button>
            <form action="/admin/menu/hapus/{{ $item->id }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus menu ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" style="background: #fef2f2; border: none; padding: 5px 10px; border-radius: 6px; color: #ef4444; cursor: pointer;">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </form>
        </div>
    </div>

    @if($item->children->count() > 0)
        <div style="margin-top: 12px; padding-left: 25px; border-left: 2px dashed #e2e8f0;">
            @foreach($item->children as $child)
                <div style="background: #f8fafc; padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 6px; display: flex; justify-content: space-between; align-items: center;">
                    <div style="font-size: 0.9rem;">
                        <span style="font-weight: 500;">{{ $child->label }}</span>
                        <code style="font-size: 0.7rem; color: #94a3b8; margin-left: 8px;">{{ $child->url }}</code>
                    </div>
                    <div style="display: flex; gap: 5px;">
                        <button type="button" onclick="editMenu(this)" 
                            data-id="{{ $child->id }}"
                            data-label="{{ $child->label }}"
                            data-url="{{ $child->url }}"
                            data-parent="{{ $item->id }}"
                            data-target="{{ $child->target }}"
                            data-posisi="{{ $child->posisi }}"
                            style="background: none; border: none; color: var(--primary); font-size: 0.8rem; cursor: pointer;">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="/admin/menu/hapus/{{ $child->id }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus sub-menu ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #ef4444; font-size: 0.8rem; cursor: pointer;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
