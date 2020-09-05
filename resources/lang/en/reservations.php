<?php
return [
    "title" => "Reservations",
    "title_create" => "Create Reservations",
    "title_update" => "Update Reservations",
    "fields" => [
        "period" => "Period",
        "property" => "Property",
        "unit" => "Unit",
        "amount" => "Amount",
        "status" => "Status",
        "source" => "Source",
        "customer_name" => "Customer Name",
        "res_id" => "Res ID",
    ],
    "filters" => [
        "to" => "To",
        "from" => "From",
        "status" => "Status",
        "search" => "Search",
        "date_type" => "Date Filter",
        "date_types" => [
            "start_date" => "Check-in Date",
            "end_date" => "Check-out Date",
            "created_at" => "Created At",
        ],
    ],
    "statuses" => [
        \ConstReservationStatuses::PENDING => "Pending",
        \ConstReservationStatuses::COMPLETED => "Completed",
        \ConstReservationStatuses::CANCELED => "Canceled",
        \ConstReservationStatuses::UPDATE => "Update",
    ]
];
