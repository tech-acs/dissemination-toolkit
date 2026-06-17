# Users

Manage user accounts, assign roles, and control access to the platform. Accessible at `manage/user` (Super Admin only).

## User list

The Users page has two tabs:

### Users tab

Displays a table of all registered users with:
- Name, email, and profile photo
- Assigned role
- Suspension status
- Edit and Delete actions per row

### Invitations tab

Use the Livewire `invitation-manager` component to send invitations to new users. Enter an email address and the system sends an invitation link. Pending invitations are listed with options to resend or revoke.

## Editing a user

1. Click **Edit** next to a user
2. Change the user's **Role** by selecting from the available roles
3. The user's profile photo, name, email, and registration date are displayed for reference

## Suspending a user

1. Navigate to the user's suspension page (`manage/user/{user}/suspension`)
2. Toggle the suspension on or off
3. Confirm your password to apply the change
4. Suspended users cannot log in until the suspension is lifted

## Deleting a user

1. Click **Delete** next to a user
2. Confirm the deletion in the dialog
3. Super Admin accounts cannot be deleted
