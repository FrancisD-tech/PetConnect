<form action="{{ route('verifications.submit') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="space-y-6">
        <div>
            <label class="block text-lg font-semibold mb-2">Full Legal Name *</label>
            <input type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}" required 
                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-purple-500 focus:outline-none">
            @error('full_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-lg font-semibold mb-2">Date of Birth *</label>
            <input type="date" name="birth_date" value="{{ old('birth_date', $user->birth_date) }}" required 
                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-purple-500 focus:outline-none">
            @error('birth_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-lg font-semibold mb-2">Complete Address *</label>
            <textarea name="address" rows="3" required 
                      class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-purple-500 focus:outline-none">{{ old('address', $user->address) }}</textarea>
            @error('address') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-lg font-semibold mb-2">Phone Number *</label>
            <input type="tel" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" required 
                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-purple-500 focus:outline-none">
            @error('phone_number') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-lg font-semibold mb-2">ID Type *</label>
            <select name="id_type" required 
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-purple-500 focus:outline-none">
                <option value="">Select ID Type</option>
                <option value="drivers_license" {{ old('id_type', $user->id_type) == 'drivers_license' ? 'selected' : '' }}>Driver's License</option>
                <option value="passport" {{ old('id_type', $user->id_type) == 'passport' ? 'selected' : '' }}>Passport</option>
                <option value="national_id" {{ old('id_type', $user->id_type) == 'national_id' ? 'selected' : '' }}>National ID</option>
                <option value="other" {{ old('id_type', $user->id_type) == 'other' ? 'selected' : '' }}>Other Government ID</option>
            </select>
            @error('id_type') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-lg font-semibold mb-2">Upload Government ID *</label>
            <input type="file" name="government_id" accept="image/*,.pdf" required 
                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-purple-500 focus:outline-none">
            <p class="text-sm text-gray-500 mt-2">Accepted formats: JPG, PNG, PDF (Max 5MB)</p>
            @error('government_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="bg-yellow-50 border-2 border-yellow-200 p-6 rounded-xl">
            <h4 class="font-bold text-lg mb-2 text-yellow-800"><i class="fas fa-info-circle"></i> Important Notes:</h4>
            <ul class="text-sm text-yellow-700 space-y-1 list-disc list-inside">
                <li>All information must match your government ID</li>
                <li>Ensure your ID photo is clear and readable</li>
                <li>Verification typically takes 24-48 hours</li>
                <li>Your data is encrypted and secure</li>
            </ul>
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-4 rounded-xl text-xl font-bold hover:shadow-2xl transition">
            <i class="fas fa-paper-plane mr-2"></i> Submit for Verification
        </button>
    </div>
</form>