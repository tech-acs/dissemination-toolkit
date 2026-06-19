# Users

Manage user accounts, assign roles, and control access to the platform. Accessible from the management **Manage** dropdown under **Access Control → Users** (Super Admin only).

## User management

The Users page has two tabs:

### Users tab

Displays a table of all registered users with:
- Name, email, and profile photo
- Assigned role
- Suspension status
- Edit, Suspend/Restore, and Delete actions per row

### Invitations tab

The Invitations tab provides two ways to invite new users.

#### Invite new user (single)

1. Click **Invite New User**
2. In the modal, enter the user's **Email address**
3. Optionally select a **Role to assign** (or leave as "Will assign later")
4. Click **Invite**

The system generates a unique registration link that expires in 72 hours. The pending invitation appears in the table below.

#### Bulk invite

1. Click **Bulk Invite**
2. Prepare a spreadsheet (`.xlsx` or `.csv`) with at least an **email** column. Optionally include a **role** column with the exact role name to assign
3. Upload the file and click **Invite**

A template can be downloaded by clicking **Download Import Template**. The system processes each row and creates an invitation for each email address.

#### Pending invitations

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
