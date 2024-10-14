<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Task;


class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'role:Admin']);
    }

    public function generateReport()
    {
        $tasks = Task::whereNotNull('assigned_to')
            ->with('assignedEmployee')
            ->get();

        $pdf = Pdf::loadView('reports.tasks', compact('tasks'));

        return $pdf->download('tasks_report.pdf');
    }
}
