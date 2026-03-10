<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50',
            'address' => 'required|string|max:255',
            'pickup_time' => 'required|date|after:now',
            'catatan' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama penerima wajib diisi',
            'name.max' => 'Nama penerima maksimal 50 karakter',
            'address.required' => 'Alamat wajib diisi',
            'address.max' => 'Alamat maksimal 255 karakter',
            'pickup_time.required' => 'Waktu penjemputan wajib diisi',
            'pickup_time.date' => 'Format waktu tidak valid',
            'pickup_time.after' => 'Waktu penjemputan harus di masa depan',
            'catatan.max' => 'Catatan maksimal 500 karakter',
        ];
    }
}
