# Users

Manage user accounts, assign roles, and control access to the platform. Accessible from the management admin menu (wrench icon) under **Access Control → Users** (Super Admin only).

## User list

The Users page has two tabs:

### Users tab

Displays a table of all registered users with:
- Name, email, and profile photo
- Assigned role
- Suspension status
- Edit, Suspend/Restore, and Delete actions per row

### Invitations tab

Use the **Invitations** tab to send invitations to new users. Enter an email address and the system generates an invitation link. You can also use the bulk-invite option to invite multiple users at once.

Pending invitations are listed with options to:
- **Show link** — copy the registration link to send manually
- **Resend email** — resend the invitation email
- **Renew** — refresh an expired invitation
- **Delete** — remove the invitation

## Editing a user

1. Click **Edit** next to a user
2. Change the user's **Role** by selecting from the available roles
3. The user's profile photo, name, email, and registration date are displayed for reference

## Suspending a user

1. Click **Suspend** (or **Restore**) next to a user, or navigate to `manage/user/{user}/suspension`
2. The toggle switches the suspension status on or off
3. Suspended users cannot log in until the suspension is lifted

## Deleting a user

1. Click **Delete** next to a user
2. Confirm the deletion in the dialog
3. Super Admin accounts cannot be deleted
