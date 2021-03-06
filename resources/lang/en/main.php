<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Main Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default main messages used by
    | the project. 
    |
    */
    'imprint'             => 'Imprint',
    
    // Welcome (done)
    'welcome_github'             => ' >>> Visit us on GitHub <<< ',
    'welcome_title'             => 'Welcome to Project-D-Railing',
    'welcome_subtitle'             => 'A new way to enjoy the ride',
   
    
    // Navbar
    'navbar_home'             => 'Home',
    'navbar_toplist'             => 'Toplist',
    'navbar_map'             => 'Map',
    'navbar_station'             => 'Station',
    'navbar_train'             => 'Train',
    
    'navbar_login'             => 'Login',
    'navbar_register'             => 'Register',
    'navbar_logout'             => 'Logout',
    'navbar_back'             => 'Back to start',
    
    // Home    
    'dashboard_title'             => 'Dashboard',
    'dashboard_text'             => 'You are logged in!',
    
    // Map
    

    // Stats
    'stats_alltime'             => 'The shown data was gathered between :date and today.',
    'stats_twoweeks'             => 'The shown data was gathered in the last two weeks',

    'stats_header'             => 'Information',

    'stats_detaildate'             => 'The following table shows the timetable of the selected station for the selected date. Entries with a red background are showing the cancellation of this train.',
    'stats_detailgleis'             => 'The graph shows the usage of platforms per trainclass.',
    'stats_detailzug'             => 'The graph shows the count of trainclasses in the station.',

    'stats_cancel'             => 'The graph shows the percentage of cancelled trains. The "n" Label stands for normal, the "c" label for cancel',
    'stats_delay'             => 'The graph shows the delay of the train for each station.',
    'stats_platform'             => 'The graph shows the used platform percentage on each station',
    'stats_route'             => 'The following text blocks are showing the different routes of the selected train.',
    'stats_stations'             => 'The following table shows the stations on the route of the train.',

    // Search
    'search_nothing_found'  => 'Nothing found.',
    
    // Station
    'station_search'             => 'Search station:',
    'station_search_help'             => 'Search by name',
    'station_subtext'             => 'There will be all time stats somewhere later on.',
    'station_select_date'             => 'Please select a date:',
    'station_col_zugnummer'             => 'Trainnumber',
    'station_col_arzeitsoll'             => 'arrival time (should)',
    'station_col_arzeitist'             => 'arrival time (is)',
    'station_col_dpzeitsoll'             => 'departure time (should)',
    'station_col_dpzeitist'             => 'departure time (is)',
    'station_col_gleissoll'             => 'platform (should)',
    'station_col_gleisist'             => 'platform (is)',
    'station_col_show'             => 'show detail',
    'station_button_show'             => 'show',
    'station_no_trains'             => 'There are no trains for the selected date.',
    'station_timetable'             => 'Timetable',
    'station_trainstats'             => 'Traintypestatistic',
    'station_platformstats'             => 'Platformstatistics',
    
    // Train
    'train_search'             => 'Search train:',
    'train_search_help'             => 'Seary by trainnumber',
    'train_no_stats'             => 'There are no statistics for this train.',    
    'train_stations'             => 'Stations',    
    'train_delay'             => 'Delaystatistics',    
    'train_cancel'             => 'Cancelstatistics',    
    'train_platform'             => 'Platformstatistics',    
    'train_routes'             => 'Routestatistics',
    // Auth
    'auth_register'             => 'Register',
    'auth_login'             => 'Login',
    'auth_name'             => 'Name',
    'auth_mail'             => 'E-Mail Address',
    'auth_password'             => 'Password',
    'auth_password_confirm'             => 'Confirm Password',
    'auth_password_forgot'             => 'Forgot Your Password?',
    'auth_remember'             => 'Remember Me',
    'auth_reset_password'             => 'Reset Password',
    'auth_send_reset'             => 'Send Password Reset Link',
];
