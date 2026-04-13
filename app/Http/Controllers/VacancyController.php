<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VacancyController extends Controller
{
    public function index()
    {
        $vacancies = \App\Models\Vacancy::active()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('vacancies.index', compact('vacancies'));
    }

    public function detail($slug)
    {
        $vacancy = \App\Models\Vacancy::active()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('vacancies.detail', compact('vacancy'));
    }
}
