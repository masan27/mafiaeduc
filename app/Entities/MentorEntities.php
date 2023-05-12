<?php

namespace App\Entities;

class MentorEntities
{
    const MENTOR_STATUS_PENDING_APPROVAL = 0;
    const MENTOR_STATUS_APPROVED = 1;
    const MENTOR_STATUS_REJECTED = 2;
    const MENTOR_STATUS_BLOCKED = 3;

    const MENTOR_STATUS_PENDING_APPROVAL_TEXT = 'Pending Approval';

    const MENTOR_STATUS_APPROVED_TEXT = 'Approved';

    const MENTOR_STATUS_REJECTED_TEXT = 'Rejected';

    const MENTOR_STATUS_BLOCKED_TEXT = 'Blocked';

    const ACTIVE_CREDENTIALS = 1;
    const INACTIVE_CREDENTIALS = 0;
}
