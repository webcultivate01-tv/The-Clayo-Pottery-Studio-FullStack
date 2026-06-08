<?php
declare(strict_types=1);

namespace Calyo\Controllers;

use Calyo\Core\Controller;
use Calyo\Core\Request;
use Calyo\Core\Session;
use Calyo\Models\Client;

final class ClientController extends Controller
{
    private Client $model;

    public function __construct()
    {
        $this->model = new Client();
    }

    public function index(Request $request): void
    {
        $filters = $this->readFilters($request);
        $page    = max(1, (int) $request->input('page', 1));
        $result  = $this->model->paginate($filters, $page);

        $this->view('clients.index', [
            'title'   => 'Clients',
            'result'  => $result,
            'filters' => $filters,
        ]);
    }

    public function store(Request $request): void
    {
        $data = $this->readClientInput($request);

        if ($data['first_name'] === '') {
            Session::flash('error', 'First name is required.');
            $this->redirect('/clients');
        }

        $this->model->create($data);
        Session::flash('success', 'Client added successfully.');
        $this->redirect('/clients');
    }

    public function update(Request $request, string $id): void
    {
        $client = $this->model->find((int) $id);
        if (!$client) {
            Session::flash('error', 'Client not found.');
            $this->redirect('/clients');
        }

        $data = $this->readClientInput($request, withStatus: true);

        if ($data['first_name'] === '') {
            Session::flash('error', 'First name is required.');
            $this->redirect('/clients');
        }

        $this->model->update((int) $id, $data);
        Session::flash('success', 'Client updated successfully.');
        $this->redirect('/clients');
    }

    public function destroy(Request $request, string $id): void
    {
        $client = $this->model->find((int) $id);
        if (!$client) {
            Session::flash('error', 'Client not found.');
            $this->redirect('/clients');
        }

        $this->model->delete((int) $id);
        Session::flash('success', 'Client deleted.');
        $this->redirect('/clients');
    }

    public function export(Request $request): void
    {
        $filters = $this->readFilters($request);
        $clients = $this->model->filter($filters);
        $format  = (string) $request->input('format', 'csv');

        if ($format === 'pdf') {
            $this->view('clients.print', [
                'title'   => 'Clients Export',
                'clients' => $clients,
                'filters' => $filters,
            ], null);
            return;
        }

        // CSV / Excel
        $filename = 'clients_' . date('Y-m-d') . '.csv';
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $out = fopen('php://output', 'w');
        // UTF-8 BOM so Excel opens it correctly
        fwrite($out, "\xEF\xBB\xBF");
        fputcsv($out, ['#', 'First Name', 'Last Name', 'Email', 'Phone', 'Company', 'Status', 'Joined']);
        foreach ($clients as $i => $c) {
            fputcsv($out, [
                $i + 1,
                $c['first_name'],
                $c['last_name'],
                $c['email']   ?? '',
                $c['phone']   ?? '',
                $c['company'] ?? '',
                $c['status'],
                date('d M Y', strtotime($c['created_at'])),
            ]);
        }
        fclose($out);
        exit;
    }

    // ── Helpers ──────────────────────────────────────────────────────────────

    private function readFilters(Request $request): array
    {
        return [
            'search'    => clean((string) $request->input('search', '')),
            'status'    => clean((string) $request->input('status', '')),
            'date_from' => clean((string) $request->input('date_from', '')),
            'date_to'   => clean((string) $request->input('date_to', '')),
        ];
    }

    private function readClientInput(Request $request, bool $withStatus = false): array
    {
        $data = [
            'first_name' => clean((string) $request->input('first_name', '')),
            'last_name'  => clean((string) $request->input('last_name', '')),
            'email'      => clean((string) $request->input('email', '')),
            'phone'      => clean((string) $request->input('phone', '')),
            'company'    => clean((string) $request->input('company', '')),
            'address'    => clean((string) $request->input('address', '')),
            'notes'      => clean((string) $request->input('notes', '')),
        ];
        if ($withStatus) {
            $allowed        = ['active', 'inactive', 'archived'];
            $s              = clean((string) $request->input('status', 'active'));
            $data['status'] = in_array($s, $allowed, true) ? $s : 'active';
        } else {
            $data['status'] = 'active';
        }
        return $data;
    }
}
