<select id="province_select" name="province" class="form-control" required>
    <option value="">انتخاب استان</option>
    @foreach($provinces as $prov)
        <option value="{{ $prov->id }}" {{ old('province') == $prov->id ? 'selected' : '' }}>
            {{ $prov->name }}
        </option>
    @endforeach
</select>
