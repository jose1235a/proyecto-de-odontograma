<?php

namespace App\Services\DentalManagement;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorService
{
    public function getPaginated(Request $request): LengthAwarePaginator
    {
        $query = Doctor::query()
            ->with('specialties')
            ->filter($request)
            ->notDeleted();

        if (!$request->filled('sort')) {
            $query->orderBy('name');
        }

        return $query->paginate(10)->appends($request->all());
    }

    public function create(array $data): Doctor
    {
        if (isset($data['document_type'])) {
            $data['document_type'] = strtolower($data['document_type']);
        }

        $data['created_by'] = auth()->id();
        $specialties = $data['specialties'] ?? [];
        unset($data['specialties']);

        // Create user automatically or use existing one
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            $user = User::create([
                'name' => $data['name'] . ' ' . $data['last_name'],
                'email' => $data['email'],
                'password' => Hash::make('password123'), // Default password
                'tenant_id' => auth()->user()->tenant_id,
                'country_id' => auth()->user()->country_id,
                'locale_id' => auth()->user()->locale_id,
                'is_active' => $data['is_active'] ?? true,
                'created_by' => auth()->id(),
            ]);
        }

        // Assign 'doctor' role by default if not already assigned
        if (!$user->hasRole('doctor')) {
            $user->assignRole('doctor');
        }

        // Only set user_id if the column exists
        if (\Schema::hasColumn('doctors', 'user_id')) {
            $data['user_id'] = $user->id;
        }

        $doctor = Doctor::create($data);

        if (!empty($specialties)) {
            $doctor->specialties()->sync($specialties);
        }

        return $doctor;
    }

    public function find($identifier): Doctor
    {
        if (is_numeric($identifier)) {
            return Doctor::findOrFail($identifier);
        }

        return Doctor::where('slug', $identifier)->firstOrFail();
    }

    public function update($identifier, array $data): Doctor
    {
        if (isset($data['document_type'])) {
            $data['document_type'] = strtolower($data['document_type']);
        }

        $specialties = $data['specialties'] ?? [];
        unset($data['specialties']);

        $doctor = $this->find($identifier);
        $doctor->update($data);

        if (!empty($specialties)) {
            $doctor->specialties()->sync($specialties);
        }

        return $doctor;
    }

    public function delete($id, string $reason): void
    {
        $doctor = $this->find($id);
        $doctor->update([
            'deleted_description' => $reason,
            'deleted_by' => auth()->id(),
        ]);
        $doctor->delete();
    }

    public function getAllSpecialties()
    {
        return \App\Models\Specialty::all();
    }

    public function exportExcel(Request $request)
    {
        \App\Jobs\DentalManagement\Doctors\GenerateDoctorsExcelJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }

    public function exportPdf(Request $request)
    {
        \App\Jobs\DentalManagement\Doctors\GenerateDoctorsPdfJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }

    public function exportWord(Request $request)
    {
        \App\Jobs\DentalManagement\Doctors\GenerateDoctorsWordJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }
}
