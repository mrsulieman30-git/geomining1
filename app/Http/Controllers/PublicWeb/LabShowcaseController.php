<?php
namespace App\Http\Controllers\PublicWeb;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
class LabShowcaseController extends Controller {
    public function index() { return Inertia::render('Public/Laboratory'); }
}
