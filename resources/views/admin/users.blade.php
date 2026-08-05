<x-app-layout>
    <x-slot name="header">
        <h1 class="h3 mb-0">الإدارة — المستخدمون</h1>
    </x-slot>

    <div class="table-responsive shadow-sm rounded border bg-white">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>الاسم</th>
                    <th>البريد</th>
                    <th>النوع</th>
                    <th>الحالة</th>
                    <th class="text-end" style="min-width: 280px;">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <form action="{{ route('admin.users.role', $user) }}" method="post" class="d-flex flex-wrap gap-1 align-items-center">
                                @csrf
                                @method('PATCH')
                                <select name="role" class="form-select form-select-sm" style="max-width: 9rem;">
                                    <option value="user" @selected($user->role === 'user')>مستخدم</option>
                                    <option value="author" @selected($user->role === 'author')>كاتب</option>
                                    <option value="admin" @selected($user->role === 'admin')>مدير</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-outline-primary">حفظ النوع</button>
                            </form>
                        </td>
                        <td>
                            @if ($user->isBanned())
                                <span class="badge bg-dark">محظور</span>
                            @else
                                <span class="badge bg-success">نشط</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex flex-wrap gap-1 justify-content-end">
                                @if ($user->id !== auth()->id())
                                    @if ($user->isBanned())
                                        <form action="{{ route('admin.users.unban', $user) }}" method="post" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success">إلغاء الحظر</button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.users.ban', $user) }}" method="post" class="d-inline" onsubmit="return confirm('حظر هذا المستخدم؟');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-warning">حظر</button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="post" class="d-inline" onsubmit="return confirm('حذف المستخدم وكتبه؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">حذف</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $users->links() }}
    </div>
</x-app-layout>
