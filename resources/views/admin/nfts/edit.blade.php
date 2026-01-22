@extends('admin.layouts.app')

@section('title', 'Edit NFT')
@section('page-title', 'Edit NFT')
@section('page-description', $nft->name)

@section('breadcrumb')
<li><a href="{{ route('admin.nfts.index') }}">NFTs</a></li>
<li class="active">Edit</li>
@endsection

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">Edit NFT: {{ $nft->name }}</h3>
      </div>
      
      <form action="{{ route('admin.nfts.update', $nft) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="box-body">
          <!-- Current Image Preview -->
          <div class="form-group text-center">
            <label>Current Image</label><br>
            <img src="{{ asset($nft->image) }}" alt="{{ $nft->name }}" style="max-width: 200px; max-height: 200px; object-fit: cover; border-radius: 8px;">
          </div>

          <div class="form-group">
            <label for="name">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $nft->name) }}" required>
            @error('name')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="image">New Image <small class="text-muted">(leave blank to keep current)</small></label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
            <p class="help-block">Accepted formats: JPEG, PNG, JPG, GIF, WEBP. Max size: 5MB</p>
            @error('image')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="background">Background Color</label>
            <input type="text" class="form-control @error('background') is-invalid @enderror" id="background" name="background" value="{{ old('background', $nft->background) }}" placeholder="#FFFFFF or gradient CSS">
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
                  <input type="number" step="0.01" min="0" class="form-control @error('value') is-invalid @enderror" id="value" name="value" value="{{ old('value', $nft->value) }}" required>
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
                  <input type="number" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $nft->price) }}">
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
              <option value="common" {{ old('rarity', $nft->rarity) == 'common' ? 'selected' : '' }}>Common</option>
              <option value="uncommon" {{ old('rarity', $nft->rarity) == 'uncommon' ? 'selected' : '' }}>Uncommon</option>
              <option value="rare" {{ old('rarity', $nft->rarity) == 'rare' ? 'selected' : '' }}>Rare</option>
              <option value="epic" {{ old('rarity', $nft->rarity) == 'epic' ? 'selected' : '' }}>Epic</option>
              <option value="legendary" {{ old('rarity', $nft->rarity) == 'legendary' ? 'selected' : '' }}>Legendary</option>
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
                <option value="{{ $user->id }}" {{ old('user_id', $nft->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
              @endforeach
            </select>
            @error('user_id')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="box-footer">
          <a href="{{ route('admin.nfts.index') }}" class="btn btn-default">Cancel</a>
          <button type="submit" class="btn btn-warning pull-right">Update NFT</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
