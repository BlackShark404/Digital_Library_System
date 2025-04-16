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
        'is_active',
        'remember_token',
        'last_login'
    ];

    protected $timestamps = true;
    protected $useSoftDeletes = true;

    
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
     * Search users by first name, last name or email
     * 
     * @param string $searchTerm
     * @return array
     */
    public function search($searchTerm)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE fname ILIKE :term 
                OR lname ILIKE :term
                OR email ILIKE :term
                AND deleted_at IS NULL
                ORDER BY lname ASC, fname ASC";
        
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
        $sql = "SELECT * FROM {$this->table} u
                WHERE u.is_active = TRUE
                AND u.last_login >= NOW() - INTERVAL ':days days'
                AND u.deleted_at IS NULL
                ORDER BY u.last_login DESC";
        
        return $this->rawQuery($sql, ['days' => $days]);
    }

    /**
     * Find a user by remember token
     * 
     * @param string $token
     * @return array|null
     */
    public function findByRememberToken($token)
    {
        return $this->firstWhere('remember_token', $token);
    }
    
    /**
     * Update user's last login time
     * 
     * @param int $userId
     * @return bool
     */
    public function updateLastLogin($userId)
    {
        $data = [
            'last_login' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->update($userId, $data);
    }
    
    /**
     * Generate a remember token for a user
     * 
     * @param int $userId
     * @return string The generated token
     */
    public function generateRememberToken($userId)
    {
        $token = bin2hex(random_bytes(32));
        
        $this->update($userId, [
            'remember_token' => $token,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        
        return $token;
    }
    
    /**
     * Clear a user's remember token
     * 
     * @param int $userId
     * @return bool
     */
    public function clearRememberToken($userId)
    {
        return $this->update($userId, [
            'remember_token' => null,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    /**
     * Get a user's full name
     * 
     * @param array $user User data array
     * @return string
     */
    public function getFullName($user)
    {
        return $user['fname'] . ' ' . $user['lname'];
    }
    
    /**
     * Activate a user account
     * 
     * @param int $userId
     * @return bool
     */
    public function activateUser($userId)
    {
        return $this->update($userId, [
            'is_active' => true,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    /**
     * Deactivate a user account
     * 
     * @param int $userId
     * @return bool
     */
    public function deactivateUser($userId)
    {
        return $this->update($userId, [
            'is_active' => false,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    /**
     * Get only active users
     * 
     * @return array
     */
    public function getActiveOnly()
    {
        return $this->where('is_active', true);
    }
    
    /**
     * Get users who haven't logged in for a specific period
     * 
     * @param int $days Number of days
     * @return array
     */
    public function getInactiveUsers($days = 90)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE (last_login IS NULL OR last_login < NOW() - INTERVAL ':days days')
                AND deleted_at IS NULL
                ORDER BY last_login ASC NULLS FIRST";
        
        return $this->rawQuery($sql, ['days' => $days]);
    }
    
    /**
     * Get admin users
     * 
     * @return array
     */
    public function getAdmins()
    {
        return $this->where('role', 'admin');
    }
    
    /**
     * Get regular users
     * 
     * @return array
     */
    public function getRegularUsers()
    {
        return $this->where('role', 'user');
    }
    
    /**
     * Change user role
     * 
     * @param int $userId
     * @param string $role Must be 'user' or 'admin'
     * @return bool
     */
    public function changeRole($userId, $role)
    {
        if (!in_array($role, ['user', 'admin'])) {
            return false;
        }
        
        return $this->update($userId, [
            'role' => $role,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}