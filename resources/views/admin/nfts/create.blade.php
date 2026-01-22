@extends('admin.layouts.app')

@section('title', 'Create NFT')
@section('page-title', 'Create NFT')
@section('page-description', 'Add a new NFT')

@section('breadcrumb')
<li><a href="{{ route('admin.nfts.index') }}">NFTs</a></li>
<li class="active">Create</li>
@endsection

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">New NFT</h3>
      </div>
      
      <form action="{{ route('admin.nfts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="box-body">
          <div class="form-group">
            <label for="name">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="image">Image <span class="text-danger">*</span></label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" required>
            <p class="help-block">Accepted formats: JPEG, PNG, JPG, GIF, WEBP. Max size: 5MB</p>
            @error('image')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="background">Background Color</label>
            <input type="text" class="form-control @error('background') is-invalid @enderror" id="background" name="background" value="{{ old('background') }}" placeholder="#FFFFFF or gradient CSS">
            @error('background')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="value">Value <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-addon">$</span>
                  <input type="number" step="0.01" min="0" class="form-control @error('value') is-invalid @enderror" id="value" name="value" value="{{ old('value') }}" required>
                </div>
                @error('value')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="price">Sale Price</label>
                <div class="input-group">
                  <span class="input-group-addon">$</span>
                  <input type="number" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}">
                </div>
                @error('price')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="rarity">Rarity <span class="text-danger">*</span></label>
            <select class="form-control @error('rarity') is-invalid @enderror" id="rarity" name="rarity" required>
              <option value="common" {{ old('rarity') == 'common' ? 'selected' : '' }}>Common</option>
              <option value="uncommon" {{ old('rarity') == 'uncommon' ? 'selected' : '' }}>Uncommon</option>
              <option value="rare" {{ old('rarity') == 'rare' ? 'selected' : '' }}>Rare</option>
              <option value="epic" {{ old('rarity') == 'epic' ? 'selected' : '' }}>Epic</option>
              <option value="legendary" {{ old('rarity') == 'legendary' ? 'selected' : '' }}>Legendary</option>
            </select>
            @error('rarity')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="user_id">Owner</label>
            <select class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id">
              <option value="">No Owner (Available for purchase)</option>
              @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
              @endforeach
            </select>
            @error('user_id')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="box-footer">
          <a href="{{ route('admin.nfts.index') }}" class="btn btn-default">Cancel</a>
          <button type="submit" class="btn btn-primary pull-right">Create NFT</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
