<?php return
[
    'table_name' =>
    [
        'id'   => [DB::int(11), DB::autoIncrement(), DB::primaryKey(), DB::notNull()],
        'name' => [DB::varchar(55)]
    ]
];
