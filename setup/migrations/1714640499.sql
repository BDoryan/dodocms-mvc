
CREATE TRIGGER delete_admin_user_sessions
    BEFORE DELETE
    ON AdminUsers
    FOR EACH ROW
BEGIN
    DELETE
    FROM AdminUsersHasSessions
    WHERE user_id = OLD.id;
END;