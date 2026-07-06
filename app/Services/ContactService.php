<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Support\Facades\Storage;

class ContactService
{
    public function getAllContacts($perPage = 10, array $filters = [])
    {
        $query = Contact::query();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['role'])) {
            $query->whereHas('roles', function ($q) use ($filters) {
                $q->where('contact_roles.id', $filters['role']);
            });
        }

        if (!empty($filters['hire_date_from'])) {
            $query->whereDate('hire_date', '>=', $filters['hire_date_from']);
        }

        if (!empty($filters['hire_date_to'])) {
            $query->whereDate('hire_date', '<=', $filters['hire_date_to']);
        }

        if (!empty($filters['managed_by'])) {
            $query->where('managed_by', $filters['managed_by']);
        }

        return $query->with('manager')->latest()->paginate($perPage)->withQueryString();
    }

    public function createContact(array $data)
    {
        if (isset($data['photo'])) {
            $data['photo'] = $this->uploadPhoto($data['photo']);
        }

        $roles = $data['roles'] ?? [];
        unset($data['roles']);

        $contact = Contact::create($data);
        $contact->roles()->sync($roles);

        return $contact;
    }

    public function updateContact(Contact $contact, array $data)
    {
        if (isset($data['photo'])) {
            if ($contact->photo) {
                Storage::disk('public')->delete($contact->photo);
            }
            $data['photo'] = $this->uploadPhoto($data['photo']);
        }

        $roles = $data['roles'] ?? [];
        unset($data['roles']);

        $contact->update($data);
        $contact->roles()->sync($roles);

        return $contact;
    }

    public function deleteContact(Contact $contact)
    {
        return $contact->delete();
    }

    private function uploadPhoto($photo)
    {
        return $photo->store('contacts', 'public');
    }
}
