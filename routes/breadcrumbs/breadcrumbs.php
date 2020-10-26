<?php

// Home
Breadcrumbs::register('dashboard', function ($breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('dashboard'));
});


/*
 *  Administration Module
 */
 
// Home > Role List
Breadcrumbs::register('role_list', function($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Role List', route('role.create'));
});

Breadcrumbs::register('role_permission', function($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Add Role Permission', route('permission.index'));
});

Breadcrumbs::register('user_list', function($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('User List', route('user-registration.index'));
});

Breadcrumbs::register('member_list', function($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Member List', route('mess-member.index'));
});

Breadcrumbs::register('market_list', function($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Market List', route('market.index'));
});


