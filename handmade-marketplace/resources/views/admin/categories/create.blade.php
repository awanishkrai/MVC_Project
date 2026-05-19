@extends('layouts.admin')
@section('page-title', 'Add category')
@section('title', 'Add Category')

@section('content')
<div class="mx-auto max-w-lg">
    <h1 class="cn-page-header">Add category</h1>
    <form method="POST" action="{{ route('admin.categories.store') }}" class="cn-card mt-8 space-y-4 p-6">
        @csrf
        <div><label class="cn-label">Name</label><input class="cn-input" name="name" value="{{ old('name') }}" required></div>
        <div><label class="cn-label">Slug (optional)</label><input class="cn-input" name="slug" value="{{ old('slug') }}"></div>
        <div><label class="cn-label">Icon (emoji)</label><input class="cn-input" name="icon" value="{{ old('icon') }}" placeholder="🎨"></div>
        <div><label class="cn-label">Description</label><textarea class="cn-input" name="description" rows="3">{{ old('description') }}</textarea></div>
        <button type="submit" class="cn-btn-primary">Create</button>
    </form>
</div>
@endsection
