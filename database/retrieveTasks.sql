-- retrieve all user tasks
SELECT * FROM tasks WHERE user_id = "user_id";
-- filter completed or incomplete tasks
SELECT * FROM tasks WHERE user_id = "user_id" AND completed = 1;
SELECT * FROM tasks WHERE user_id = "user_id" AND completed = 0;
-- filter tasks by priority
SELECT * FROM tasks WHERE user_id = "user_id" AND priority = "low";
SELECT * FROM tasks WHERE user_id = "user_id" AND priority = "medium";
SELECT * FROM tasks WHERE user_id = "user_id" AND priority = "high";
-- filter tasks by priority and complete status
SELECT * FROM tasks WHERE user_id = "user_id" AND priority = "high" AND completed = 1;
