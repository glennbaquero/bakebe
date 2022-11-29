<?php

use Illuminate\Database\Seeder;

use App\Models\Permissions\PermissionCategory;
use App\Models\Permissions\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Content Management',
                'description' => 'Manage Pages & Contents',
                'icon' => 'fa fa-feather',
                'items' => [
                    [
                        'name' => 'admin.pages.crud',
                        'description' => 'Manage Pages',
                    ],
                    [
                        'name' => 'admin.page-items.crud',
                        'description' => 'Manage Page Contents',
                    ],
                    [
                        'name' => 'admin.articles.crud',
                        'description' => 'Manage Articles',
                    ],
                ],
            ],
            [
                'name' => 'Booking/Reservation Management',
                'description' => 'Manage Booking/Reservation',
                'icon' => 'fas fa-ticket-alt',
                'items' => [
                    [
                        'name' => 'admin.bookings.index',
                        'description' => 'Show/Search reservations table',
                    ],
                    [
                        'name' => 'admin.bookings.show',
                        'description' => 'Show specific reservation',
                    ],
                    [
                        'name' => 'admin.bookings.export-report',
                        'description' => 'Export Report',
                    ],
                    [
                        'name' => 'admin.invoice.mark-claimed',
                        'description' => 'Mark As Claim The Reservation',
                    ],
                    [
                        'name' => 'admin.invoice-items.mark-as-claimed',
                        'description' => 'Mark As Claim The Ticket',
                    ],
                ],
            ],
            [
                'name' => 'Admin Management',
                'description' => 'Manage Administrators',
                'icon' => 'fa fa-user-shield',
                'items' => [
                    [
                        'name' => 'admin.admin-users.crud',
                        'description' => 'Manage Administrator Accounts',
                    ],
                    [
                        'name' => 'admin.roles.crud',
                        'description' => 'Manage Admin Roles & Permissions',
                    ],
                ],
            ],
            [
                'name' => 'User Management',
                'description' => 'Manage User Accounts',
                'icon' => 'fa fa-users',
                'items' => [
                    [
                        'name' => 'admin.users.crud',
                        'description' => 'Manage User Accounts',
                    ],
                ],
            ],
            [
                'name' => 'Branch Management',
                'description' => 'Manage Branch',
                'icon' => 'fas fa-ticket-alt',
                'items' => [
                    [
                        'name' => 'admin.branches.index',
                        'description' => 'Show/Search branches table',
                    ],
                    [
                        'name' => 'admin.branches.create',
                        'description' => 'Create branches',
                    ],
                    [
                        'name' => 'admin.branches.show',
                        'description' => 'Update branches',
                    ],
                    [
                        'name' => 'admin.branches.restore',
                        'description' => 'Restore branches',
                    ],
                    [
                        'name' => 'admin.branches.archive',
                        'description' => 'Delete branches',
                    ],
                ],
            ],
            [
                'name' => 'Coupon Management',
                'description' => 'Manage Coupon',
                'icon' => 'fas fa-ticket-alt',
                'items' => [
                    [
                        'name' => 'admin.coupons.index',
                        'description' => 'Show/Search coupons table',
                    ],
                    [
                        'name' => 'admin.coupons.create',
                        'description' => 'Create coupons',
                    ],
                    [
                        'name' => 'admin.coupons.show',
                        'description' => 'Update coupons',
                    ],
                    [
                        'name' => 'admin.coupons.restore',
                        'description' => 'Restore coupons',
                    ],
                    [
                        'name' => 'admin.coupons.archive',
                        'description' => 'Delete coupons',
                    ],
                ],
            ],
            [
                'name' => 'Coupon Usages Management',
                'description' => 'Manage Coupon Usages',
                'icon' => 'fas fa-ticket-alt',
                'items' => [
                    [
                        'name' => 'admin.couponusages.crud',
                        'description' => 'Manage Coupon Usages',
                    ],
                ],
            ],            
            [
                'name' => 'Block Date and Time Management',
                'description' => 'Manage Block Date and Time',
                'icon' => 'fas fa-ticket-alt',
                'items' => [
                    [
                        'name' => 'admin.intervals.index',
                        'description' => 'Show/Search Block Date and Time table',
                    ],
                    [
                        'name' => 'admin.intervals.create',
                        'description' => 'Create Block Date and Time',
                    ],
                    [
                        'name' => 'admin.intervals.show',
                        'description' => 'Update Block Date and Time',
                    ],
                    [
                        'name' => 'admin.intervals.restore',
                        'description' => 'Restore Block Date and Time',
                    ],
                    [
                        'name' => 'admin.intervals.archive',
                        'description' => 'Delete Block Date and Time',
                    ],
                ],
            ],
            // [
            //     'name' => 'Invoices/Reservation Management',
            //     'description' => 'Manage Invoice/Reservation',
            //     'icon' => 'fas fa-ticket-alt',
            //     'items' => [
            //         [
            //             'name' => 'admin.invoices.index',
            //             'description' => 'Show/Search Invoice/Reservation table',
            //         ],
            //         [
            //             'name' => 'admin.invoices.show',
            //             'description' => 'Update Invoice/Reservation',
            //         ],
            //     ],
            // ], 
            [
                'name' => 'Pastry Management',
                'description' => 'Manage Pastries',
                'icon' => 'fas fa-ticket-alt',
                'items' => [
                    [
                        'name' => 'admin.pastries.index',
                        'description' => 'Show/Search Pastries table',
                    ],
                    [
                        'name' => 'admin.pastries.create',
                        'description' => 'Create pastries',
                    ],
                    [
                        'name' => 'admin.pastries.show',
                        'description' => 'Update pastries',
                    ],
                    [
                        'name' => 'admin.pastries.restore',
                        'description' => 'Restore pastries',
                    ],
                    [
                        'name' => 'admin.pastries.archive',
                        'description' => 'Delete pastries',
                    ],
                ],
            ],
            [
                'name' => 'Pastry Categories Management',
                'description' => 'Manage Pastry Categories',
                'icon' => 'fas fa-ticket-alt',
                'items' => [
                    [
                        'name' => 'admin.categories.index',
                        'description' => 'Show/Search categories table',
                    ],
                    [
                        'name' => 'admin.categories.create',
                        'description' => 'Create categories',
                    ],
                    [
                        'name' => 'admin.categories.show',
                        'description' => 'Update categories',
                    ],
                    [
                        'name' => 'admin.categories.restore',
                        'description' => 'Restore categories',
                    ],
                    [
                        'name' => 'admin.categories.archive',
                        'description' => 'Delete categories',
                    ],
                ],
            ],
            [
                'name' => 'Ticket Type Management',
                'description' => 'Manage Ticket Type',
                'icon' => 'fas fa-ticket-alt',
                'items' => [
                    [
                        'name' => 'admin.promos.index',
                        'description' => 'Show/Search Ticket Type table',
                    ],
                    [
                        'name' => 'admin.promos.create',
                        'description' => 'Create Ticket Type',
                    ],
                    [
                        'name' => 'admin.promos.show',
                        'description' => 'Update Ticket Type',
                    ],
                    [
                        'name' => 'admin.promos.restore',
                        'description' => 'Restore Ticket Type',
                    ],
                    [
                        'name' => 'admin.promos.archive',
                        'description' => 'Delete Ticket Type',
                    ],
                ],
            ], 

            [
                'name' => 'Booking Type Management',
                'description' => 'Manage Booking Type',
                'icon' => 'fas fa-ticket-alt',
                'items' => [
                    [
                        'name' => 'admin.types.index',
                        'description' => 'Show/Search types table',
                    ],
                    [
                        'name' => 'admin.types.show',
                        'description' => 'Update types',
                    ],
                ],
            ],                                                         
            [
                'name' => 'Activity Logs',
                'description' => 'View Activity Logs',
                'icon' => 'fa fa-shield-alt',
                'items' => [
                    [
                        'name' => 'admin.activity-logs.crud',
                        'description' => 'View Activity Logs',
                    ],
                ],
            ],
        ];

    	foreach ($categories as $category) {
            $permissions = $category['items'];
            unset($category['items']);

            $item = PermissionCategory::where('name', $category['name'])->first();

            if (!$item) {
                $this->command->info('Adding permission category ' . $category['name'] . '...');
                $item = PermissionCategory::create($category);
            } else {
                $this->command->warn('Updating permission category ' . $category['name'] . '...');
                $item->update($category);
            }


            foreach ($permissions as $permission) {
                $permissionItem = Permission::where('name', $permission['name'])->first();
                
                if (!$permissionItem) {
                    $this->command->info('Adding permission ' . $permission['name'] . '...');
                    $item->permissions()->create($permission);
                } else {
                    $this->command->warn('Updating permission ' . $permission['name'] . '...');
                    unset($permission['name']);
                    $permissionItem->update($permission);
                }
            }
    	}
    }
}
