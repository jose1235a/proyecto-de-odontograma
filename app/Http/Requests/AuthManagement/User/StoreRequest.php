<?php

// Namespace
namespace App\Http\Requests\AuthManagement\User;

// Use Illuminates
use Illuminate\Foundation\Http\FormRequest;

// Main class
class StoreRequest extends FormRequest
{
    // Authorize
    public function authorize(): bool
    {
      // Allow request
      return true; 
    }

    // Rules
    public function rules(): array
    {
      // Validations
      return [
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
        'photo'    => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        'role'     => 'required|string|exists:roles,name',
      ];
    }

    // Messages
    public function messages(): array
    {
      // Validation Messages
      return [
        'name.max'     => 'El nombre debe tener como máximo 255 caracteres.',
        'email.unique' => 'El email ya existe.',
        'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        'photo.image'  => 'El archivo debe ser una imagen válida.',
        'photo.mimes'  => 'La imagen debe ser de tipo: jpg, jpeg, png o gif.',
        'photo.max'    => 'La imagen no debe superar los 2 MB.',
      ];
    }
    
}
