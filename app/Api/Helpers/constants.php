<?php

/**
 * Class ConstGeneralStatuses
 */
class ConstGeneralStatuses
{
    const NO = 0;
    const YES = 1;
}

/**
 * Class ConstRateDefaultValues
 */
class ConstRateDefaultValues
{
    const MIN_STAY = 1;
    const MAX_STAY = 999;
    const CTA = 0;
    const CTD = 0;
    const STOP_SELL = 0;
    const CUTOFF = 0;
}

/**
 * Class ConstReservationStatuses
 */
class ConstReservationStatuses
{
    const CANCELED = 1;
    const COMPLETED = 2;
    const UPDATE = 3;
    const PENDING = 4;
}

/**
 * Class ConstClusterFrequencies
 */
class ConstClusterFrequencies
{
    const SLOW = 1;
    const MEDIUM = 2;
    const HIGH = 3;
}

/**
 * Class ConstRoles
 */
class ConstRoles
{
    const ADMIN = 'admin';
    const API_USER = 'api user';
    const MANAGER = 'manager';
    const STAFF = 'staff';
    const OWNER = 'owner';
    const CLEANING_SERVICE = 'cleaning service';
}

/**
 * Class ConstPermissions
 */
class ConstPermissions
{
    // Reservations
    const VIEW_RESERVATIONS = 'View Reservations';
    const EDIT_RESERVATIONS = 'Edit Reservations';
    const EDIT_OTA_RESERVATIONS = 'Edit OTA Reservations';
    const CREATE_RESERVATIONS = 'Create Reservations';
    const CANCEL_RESERVATIONS = 'Cancel Reservations';
    const DELETE_RESERVATIONS = 'Delete Reservations';
    const VIEW_RESERVATIONS_DETAILS = 'View Reservations Details';
    const EXPORT_RESERVATIONS = 'Export Reservations';
    const EDIT_PENDING_ROOM_TYPE = 'Edit Reservation Pending Room Type';
    const EDIT_EMERCHANT_PAYMENTS = 'Edit Emerchant Payments';

    const VIEW_EXTRAS = 'View Extras';
    const EDIT_EXTRAS = 'Edit Extras';
    const DELETE_EXTRAS = 'Delete Extras';

    // Clients
    const VIEW_CLIENTS = 'View Clients';
    const EDIT_CLIENTS = 'Edit Clients';
    const CREATE_CLIENTS = 'Create Clients';
    const DELETE_CLIENTS = 'Delete Clients';
    const EXPORT_CLIENTS = 'Export Clients';

    const EXPORT_PAYMENTS = 'Export Payments';


    // Reservation Calendar
    const VIEW_RESERVATION_CALENDAR = 'View Reservation Calendar';
    const VIEW_RESERVATION_CALENDAR_DETAILS = 'View Reservation Calendar Details';
    const EDIT_RATE_AVAILABILITY = 'Edit Rate Availability';

    // Rate Calendar
    const VIEW_RATE_CALENDAR = 'View Rate Calendar';
    const EDIT_RATE_CALENDAR = 'Edit Rate Calendar';
    const SYNC_RATE_CALENDAR = 'Sync Rate Calendar';

    // RMT
    const VIEW_RMT = 'View RMT';

    // Accounting
    const VIEW_ACCOUNTING = 'View Accounting';

    // Statistics
    const VIEW_STATISTICS = 'View Statistics';

    // Properties
    const VIEW_PROPERTIES = 'View Properties';
    const CREATE_PROPERTIES = 'Create Properties';
    const EDIT_PROPERTIES = 'Edit Properties';
    const DELETE_PROPERTIES = 'Delete Properties';
    const MANAGE_DERIVATION_RULES = 'Manage Derivation Rules';
    const ADVANCED_EDIT_PROPERTIES = 'Advanced Edit Properties';

    // Dashboard
    const VIEW_DASHBOARD_STATISTICS = 'View Dashboard Statistics';

    // Checkinplan
    const VIEW_CHECKINPLAN = 'View Checkin Plan';
    const VIEW_GUEST_DETAILS = 'View Guest Details';
    const VIEW_RESERVATION_AMOUNT = 'View Reservation Amount';
    const VIEW_SERVICE_NOTES = 'View Service Notes';
    const VIEW_INTERNAL_NOTE = 'View Internal Notes';
    const EDIT_CHECK_IN_OUT_STATUS = 'Edit Checkin Status';
    const EXPORT_CHECKINPLAN = 'Export Checkin Plan';

    // Costs
    const MANAGE_COSTS = 'Manage Costs';

    // Templates
    const MANAGE_TEMPLATES = 'Manage Templates';

    // Users
    const VIEW_USERS = 'View Users';
    const CREATE_USERS = 'Add Users';
    const EDIT_USERS = 'Edit Users';
    const DELETE_USERS = 'Delete Users';
    const MANAGE_TEAMS = 'Manage Teams';
    const ASSIGN_PROPERTIES = 'Assign Properties';
    const MANAGE_USER_SECURITY = 'Manager User Security';

    // Room Types
    const VIEW_ROOM_TYPES = 'View Room Types';
    const EDIT_ROOM_TYPES = 'Edit Room Types';
    const DELETE_ROOM_TYPES = 'Delete Room Types';

    // Booking Engine
    const BOOKING_ENGINE = 'Booking engine';

    const MANAGE_TRANSLATIONS = 'Manage Translations';

    // Legal Compliance and Guest management
    const VIEW_LEGAL_REQUESTS_LIST = 'View Legal Compliance Requests';
    const VIEW_RESERVATION_GUESTS = 'View Reservation Guests';
    const CREATE_RESERVATION_GUESTS = 'Add Reservation Guests';
    const EDIT_RESERVATION_GUESTS = 'Edit Reservation Guests';
    const DELETE_RESERVATION_GUESTS = 'Delete Reservation Guests';

    // Billings
    const VIEW_BILLING = 'View Billing';
    const CREATE_BILL = 'Create Bill';
    const EDIT_BILL = 'Edit Bill';
    const DELETE_BILL = 'Delete Bill';
}

/**
 * Class ConstIconPack
 */
class ConstIconPack
{
    const FONTAWESOME = 'Font Awesome';
    const MDI = 'MDI';
}

/**
 * Class constClientType
 */
class ConstClientType
{
    const PRIVATE = 1;
    const COMPANY = 2;
}

/**
 * Class ConstCurrencies
 */
class ConstCurrencies
{
    const EUR = 'EUR';
    const USD = 'USD';
}

/**
 * Class ConstDerivationRules
 */
class ConstDerivationRules
{
    const UNLINKED = 3;
    const CURRENCY = 1;
    const PERCENTAGE = 2;
}

/**
 * Class ConstCiaoBookingVersions
 */
class ConstCiaoBookingVersions
{
    const V1 = 1;
    const V2 = 2;
    const V3 = 3;
}

/**
 * Class ConstPriceCorrectionType
 */
class ConstPriceCorrectionType
{
    const PERCENTAGE = 1;
    const FIXED = 2;
}

/**
 * Class ConstCityTaxType
 */
class ConstCityTaxType
{
    const FIXED_AMOUNT = 1;
    const PERCENTAGE = 2;
}

/**
 * Class ConstPriceVariation
 */
class ConstPriceVariation
{
    const EXACT = 1;
    const INCREMENT = 2;
    const PERCENT = 3;
}

/**
 * Class ConstRateModifications
 */
class ConstRateModifications
{
    const DERIVATION = 1;
    const RATE_CALENDAR = 2;
    const RESERVATION_CREATE = 3;
    const RESERVATION_UPDATE = 4;
    const RESERVATION_CANCEL = 5;
}

/**
 * Class ConstRateCalendarTypes
 */
class ConstRateCalendarTypes
{
    const DETAILED = 1;
    const COMPRESSED = 2;
}
