<?php

namespace App\Http\Controllers;

use App\Models\OrganizationUnit;
use Illuminate\Http\Request;

class OrganizationAdminUnitController extends Controller
{
    /**
     * Only Organization Admin can manage organization units.
     */
    private function authorizeUnitAccess(): void
    {
        if (auth()->user()->role !== 'organization_admin') {
            abort(
                403,
                'Only the organization administrator can manage organization units.'
            );
        }
    }


    public function index(Request $request)
    {
        $this->authorizeUnitAccess();

        $organization = auth()->user()->currentOrganization();

        if (!$organization) {
            abort(404, 'Organization not found.');
        }

        $units = $organization->organizationUnits()
            ->when(
                $request->filled('search'),
                function ($query) use ($request) {

                    $search = trim($request->search);

                    $query->where(function ($q) use ($search) {
                        $q->where(
                            'name',
                            'like',
                            '%' . $search . '%'
                        )
                            ->orWhere(
                                'type',
                                'like',
                                '%' . $search . '%'
                            )
                            ->orWhere(
                                'description',
                                'like',
                                '%' . $search . '%'
                            );
                    });
                }
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'organization_admin.units.index',
            compact(
                'organization',
                'units'
            )
        );
    }


    public function search(Request $request)
    {
        $this->authorizeUnitAccess();

        $organization = auth()->user()->currentOrganization();

        if (!$organization) {
            return response()->json([]);
        }

        $search = trim(
            $request->get('q', '')
        );

        $units = $organization->organizationUnits()
            ->when(
                $search !== '',
                function ($query) use ($search) {

                    $query->where(function ($q) use ($search) {

                        $q->where(
                            'name',
                            'like',
                            '%' . $search . '%'
                        )
                            ->orWhere(
                                'type',
                                'like',
                                '%' . $search . '%'
                            )
                            ->orWhere(
                                'description',
                                'like',
                                '%' . $search . '%'
                            );
                    });
                }
            )
            ->orderBy('name')
            ->limit(20)
            ->get();

        return response()->json(
            $units->map(
                function ($unit) {

                    return [
                        'id' => $unit->id,
                        'name' => $unit->name,
                        'type' => $unit->type,
                        'description' => $unit->description,
                        'status' => $unit->status,
                    ];
                }
            )->values()
        );
    }


    public function create()
    {
        $this->authorizeUnitAccess();

        $organization = auth()->user()->currentOrganization();

        if (!$organization) {
            abort(404, 'Organization not found.');
        }

        return view(
            'organization_admin.units.create',
            compact('organization')
        );
    }


    public function store(Request $request)
    {
        $this->authorizeUnitAccess();

        $organization = auth()->user()->currentOrganization();

        if (!$organization) {
            abort(404, 'Organization not found.');
        }

        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',

                function (
                    $attribute,
                    $value,
                    $fail
                ) use ($organization) {

                    $exists = OrganizationUnit::where(
                        'organization_id',
                        $organization->id
                    )
                        ->whereRaw(
                            'LOWER(name) = ?',
                            [
                                strtolower(
                                    trim($value)
                                )
                            ]
                        )
                        ->exists();

                    if ($exists) {
                        $fail(
                            'This organization unit already exists.'
                        );
                    }
                },
            ],

            'type' => [
                'nullable',
                'string',
                'max:100',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'in:active,inactive',
            ],
        ]);


        $validated['organization_id'] =
            $organization->id;

        $validated['name'] =
            trim($validated['name']);


        OrganizationUnit::create(
            $validated
        );


        return redirect()
            ->route(
                'organization.admin.units.index'
            )
            ->with(
                'success',
                'Organization unit created successfully.'
            );
    }


    public function show(OrganizationUnit $unit)
    {
        $this->authorizeUnitAccess();

        $this->authorizeOrganizationUnit(
            $unit
        );

        $unit->load([
            'organization',
            'events' => function ($query) {
                $query->latest('event_date');
            },
        ]);

        return view(
            'organization_admin.units.show',
            compact('unit')
        );
    }


    public function edit(OrganizationUnit $unit)
    {
        $this->authorizeUnitAccess();

        $this->authorizeOrganizationUnit(
            $unit
        );

        return view(
            'organization_admin.units.edit',
            [
                'organizationUnit' => $unit
            ]
        );
    }


    public function update(
        Request $request,
        OrganizationUnit $unit
    ) {
        $this->authorizeUnitAccess();

        $this->authorizeOrganizationUnit(
            $unit
        );

        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',

                function (
                    $attribute,
                    $value,
                    $fail
                ) use ($unit) {

                    $exists = OrganizationUnit::where(
                        'organization_id',
                        $unit->organization_id
                    )
                        ->where(
                            'id',
                            '!=',
                            $unit->id
                        )
                        ->whereRaw(
                            'LOWER(name) = ?',
                            [
                                strtolower(
                                    trim($value)
                                )
                            ]
                        )
                        ->exists();

                    if ($exists) {
                        $fail(
                            'This organization unit already exists.'
                        );
                    }
                },
            ],

            'type' => [
                'nullable',
                'string',
                'max:100',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'in:active,inactive',
            ],
        ]);


        $validated['name'] =
            trim($validated['name']);


        $unit->update(
            $validated
        );


        return redirect()
            ->route(
                'organization.admin.units.index'
            )
            ->with(
                'success',
                'Organization unit updated successfully.'
            );
    }


    public function destroy(
        OrganizationUnit $unit
    ) {
        $this->authorizeUnitAccess();

        $this->authorizeOrganizationUnit(
            $unit
        );

        $unit->delete();


        return redirect()
            ->route(
                'organization.admin.units.index'
            )
            ->with(
                'success',
                'Organization unit deleted successfully.'
            );
    }


    /**
     * Make sure unit belongs to logged-in organization.
     */
    private function authorizeOrganizationUnit(
        OrganizationUnit $unit
    ): void {

        $organization =
            auth()->user()->currentOrganization();

        if (
            !$organization ||
            $unit->organization_id !==
                $organization->id
        ) {
            abort(
                403,
                'Unauthorized access.'
            );
        }
    }
}