<?php

namespace App\Models;

/**
 * User Model
 * 
 * This model represents a user in the system and demonstrates how to
 * extend the BaseModel class with specific functionality.
 */
class UserModel extends BaseModel
{
    /**
     * Table name for this model
     * @var string
     */
    protected $table = 'users';
    
    /**
     * Primary key column name
     * @var string
     */
    protected $primaryKey = 'id';
    
    /**
     * Fillable attributes (for mass assignment)
     * @var array
     */
    protected $fillable = [
        'fname',
        'lname',
        'email',
        'password',
        'role',
        'created_at',
        'updated_at'
    ];

    
    /**
     * Find a user by email
     * 
     * @param string $email
     * @return array|null
     */
    public function findByEmail($email)
    {
        return $this->firstWhere('email', $email);
    }
    
    /**
     * Get all users with a specific role
     * 
     * @param string $role
     * @return array
     */
    public function getByRole($role)
    {
        return $this->where('role', $role);
    }
    
    /**
     * Get users ordered by newest first
     * 
     * @return array
     */
    public function getNewest()
    {
        return $this->orderBy('created_at', 'DESC');
    }
    
    /**
     * Search users by name or email
     * 
     * @param string $searchTerm
     * @return array
     */
    public function search($searchTerm)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE name ILIKE :term 
                OR email ILIKE :term
                ORDER BY name ASC";
        
        return $this->rawQuery($sql, ['term' => "%$searchTerm%"]);
    }
    
    /**
     * Hash a password
     * 
     * @param string $password
     * @return string
     */
    public function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }
    
    /**
     * Verify a password
     * 
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
    
    /**
     * Create a new user with hashed password
     * 
     * @param array $data
     * @return int
     */
    public function createUser(array $data)
    {
        // Hash the password before creating
        if (isset($data['password'])) {
            $data['password'] = $this->hashPassword($data['password']);
        }
        
        // Set timestamps
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->create($data);
    }
    
    /**
     * Update a user
     * 
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateUser($id, array $data)
    {
        // Hash the password if it's being updated
        if (isset($data['password'])) {
            $data['password'] = $this->hashPassword($data['password']);
        }
        
        // Update the timestamp
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->update($id, $data);
    }
    
    /**
     * Get user with related posts
     * 
     * @param int $userId
     * @return array
     */
    public function getUserWithPosts($userId)
    {
        $user = $this->find($userId);
        
        if (!$user) {
            return null;
        }
        
        // Assuming there's a posts table with user_id as foreign key
        $sql = "SELECT p.* FROM posts p WHERE p.user_id = :user_id ORDER BY p.created_at DESC";
        $posts = $this->rawQuery($sql, ['user_id' => $userId]);
        
        $user['posts'] = $posts;
        return $user;
    }
    
    /**
     * Check if email exists
     * 
     * @param string $email
     * @return bool
     */
    public function emailExists($email)
    {
        return $this->findByEmail($email) !== null;
    }
    
    /**
     * Get active users (example of a complex query)
     * 
     * @param int $days Active in last X days
     * @return array
     */
    public function getActiveUsers($days = 30)
    {
        $sql = "SELECT u.*, 
                (SELECT COUNT(*) FROM posts WHERE user_id = u.id) as post_count
                FROM {$this->table} u
                WHERE u.last_login_at >= NOW() - INTERVAL ':days days'
                ORDER BY post_count DESC";
        
        return $this->rawQuery($sql, ['days' => $days]);
    }
}