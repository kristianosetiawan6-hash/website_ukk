<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function process(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'period' => ['required', 'string', 'max:40'],
            'employees' => ['required', 'array', 'min:1', 'max:5000'],
            'employees.*.name' => ['required', 'string', 'max:160'],
            'employees.*.basic_salary' => ['required', 'integer', 'min:0'],
            'employees.*.allowance' => ['nullable', 'integer', 'min:0'],
            'employees.*.deduction' => ['nullable', 'integer', 'min:0'],
        ]);

        $total = 0;
        foreach ($validated['employees'] as $employee) {
            $allowance = $employee['allowance'] ?? 0;
            $deduction = $employee['deduction'] ?? 0;
            if ($deduction > $employee['basic_salary'] + $allowance) {
                abort(422, 'Potongan tidak boleh melebihi gaji pokok dan tunjangan.');
            }

            $total += $employee['basic_salary'] + $allowance - $deduction;
        }

        $result = [
            'period' => $validated['period'],
            'count' => count($validated['employees']),
            'total' => $total,
            'status' => 'Selesai',
        ];

        $request->session()->put('processedPayroll', $result);

        return response()->json($result);
    }
}