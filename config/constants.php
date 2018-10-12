<?php

return [
    'order' => [
        "status" => [
            -1 => 'Cancelled',
            0 => 'Not Delivered',
            1 => 'Placed',
            2 => 'Confirmed',
            3 => 'Preparing',
            4 => 'Dispatched',
            5 => 'Delivered'
            ],
        'action' => [
            -1 => 'Cancel',
            0 => 'Mark as Not Delivered',
            1 => 'Place',
            2 => 'Confirm',
            3 => 'Prepare',
            4 => 'Dispatch',
            5 => 'Deliver'
        ],
        'title' => [
            -1 => 'Pazatto - Order Cancelled',
            0 => 'Pazatto - Order Not Delivered',
            1 => 'Pazatto - Order Placed',
            2 => 'Pazatto - Order Confirmed',
            3 => 'Pazatto - Order Preparing',
            4 => 'Pazatto - Order Dispatched',
            5 => 'Pazatto - Order Delivered'
        ],
        'message' => [
            -1 => 'Order of Rs. %d has been cancelled.',
            0 => 'Order of Rs. %d could not be delivered.',
            1 => 'Order of Rs. %d has been placed.',
            2 => 'Order of Rs. %d has been confirmed.',
            3 => 'Order of Rs. %d is being prepared.',
            4 => 'Order of Rs. %d has been dispatched.',
            5 => 'Order of Rs. %d has been delivered.'
        ],
        'tag' => [
            -1 => 'ORDER_CANCELLED',
            0 => 'ORDER_NOT_DELIVERED',
            1 => 'ORDER_PLACED',
            2 => 'ORDER_CONFIRMED',
            3 => 'ORDER_PREPARING',
            4 => 'ORDER_DISPATCHED',
            5 => 'ORDER_DELIVERED'
        ]
    ]
];