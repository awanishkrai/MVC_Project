@extends('layouts.admin')
@section('page-title', 'Edit category')
@section('title', 'Edit Category')

@section('content')
<div class="mx-auto max-w-lg">
    <h1 class="cn-page-header">Edit category</h1>
    <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="cn-card mt-8 space-y-4 p-6">
        @csrf @method('PUT')
        <div><label class="cn-label">Name</label><input class="cn-input" name="name" value="{{ old('name', $category->name) }}" required></div>
        <div><label class="cn-label">Slug</label><input class="cn-input" name="slug" value="{{ old('slug', $category->slug) }}"></div>
        <div><label class="cn-label">Icon</label><input class="cn-input" name="icon" value="{{ old('icon', $category->icon) }}"></div>
        <div><label class="cn-label">Description</label><textarea class="cn-input" name="description" rows="3">{{ old('description', $category->description) }}</textarea></div>
        <button type="submit" class="cn-btn-primary">Update</button>
    </form>
</div>
@endsection
