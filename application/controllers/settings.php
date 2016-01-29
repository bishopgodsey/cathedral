<?php
class Settings extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->auth->restrict('You have to log in to view this page');
		$this->load->library(array('layout'));
		$this->load->helper('form');
		
	}
	
	public function index() {
		$this->users();
	}
	
	public function users() {

        // Restrict access to users with Users.View (View Permission ) permission
        $this->auth->restrict(array('type'=>'warning',
            'text'=>'You dont have right to view users'), 'Users.View');

		// SB Admin CSS - Include with every page
		$this->layout->add_css('sb-admin');
		
		// SB Admin Scripts - Include with every page
		$this->layout->add_js('sb-admin');
		$this->layout->add_js('users_list');
		
		$this->load->model('user_model');
		
		$users = $this->user_model->get_all();
		
		$user_columns = array('Username','First Name','Last Name','Display Name','Email','Last Login', 'Status');

        if(has_permission('Users.Edit') || has_permission('Users.Delete')) {
            $user_columns[] = 'Actions';  
        }

		$data['users'] = $users;
		$data['user_columns'] = $user_columns;
				
		$this->layout->view('users_list',$data);
		
		
	}
	
	function createUser($is_ajax = 0) {
		
        $this->auth->restrict(array('type'=>'warning',
            'text'=>'You dont have the permission to access this page'), 'Users.Add');
        
        $data['ajax'] = $is_ajax;
		
		if($is_ajax) {
			$this->load->view('user_form',$data);
		}else {
			// SB Admin CSS - Include with every page
			$this->layout->add_css('sb-admin');
		
			// SB Admin Scripts - Include with every page
			$this->layout->add_js('sb-admin');
			$this->layout->view('user_form',$data);
		}
	}
	
	function saveUser() {
		$is_ajax = $this->input->post('ajax');
	    
        $this->load->library('form_validation');
        
        $user_id = $this->input->post('id');
        
        //check if the user id exists. If it's exists that would mean we are 
        //updating the user

        
        //if new user save
        if(empty($user_id)) {
                    
            $config = array(
                   array(
                         'field'   => 'username', 
                         'label'   => 'Username', 
                         'rules'   => 'required|min_length[3]|is_unique[users.username]|max_length[50]|trim'
                      ),
                   array(
                         'field'   => 'password_hash', 
                         'label'   => 'Password', 
                         'rules'   => 'required|min_length[3]|max_length[50]'
                      ),
                   array(
                         'field'   => 'display_name', 
                         'label'   => 'Display Name', 
                         'rules'   => 'required|min_length[3]|max_length[50]'
                      ),   
                   array(
                         'field'   => 'email', 
                         'label'   => 'Email', 
                         'rules'   => 'required|valid_email|is_unique[users.email]|trim|xss_clean'
                      ),
                    array(
                        'field' => 'role_id',
                        'label' => 'Role',
                        'rules'=>'required'
                    )
            );
        }else {
            //update the user 
            
            $config = array(
                   array(
                         'field'   => 'username', 
                         'label'   => 'Username', 
                         'rules'   => 'required|min_length[3]|max_length[50]|trim'
                      ),
                   array(
                         'field'   => 'password_hash', 
                         'label'   => 'Password', 
                         'rules'   => 'min_length[3]|max_length[50]'
                      ),
                   array(
                         'field'   => 'display_name', 
                         'label'   => 'Display Name', 
                         'rules'   => 'required|min_length[3]|max_length[50]'
                      ),   
                   array(
                         'field'   => 'email', 
                         'label'   => 'Email', 
                         'rules'   => 'required|valid_email|trim|xss_clean'
                      ),
                    array(
                        'field' => 'role_id',
                        'label' => 'Role',
                        'rules'=>'required'
                    )
                );
            
        }    
		

		$this->form_validation->set_rules($config);
		
		if($this->form_validation->run()===FALSE) {
		
			$this->createUser($is_ajax);
		}else {
		
			$this->load->model('user_model');
			$this->load->helper('security');
			
            $user_data = $this->input->post();

            unset($user_data['ajax']);

            if(empty($user_data['id'])) {
                //if new user save  
                unset($user_data['id']);     
                $user_data['password_hash'] = do_hash($user_data['password_hash']);
                $user_data['last_ip'] = $this->session->userdata('ip_address');
                
                $user_data['active'] = true;

                $message = array();
                if($this->user_model->save_user($user_data)) {
                    $message['type'] = 'success';
                    $message['text'] = 'User account created Successfully';
                }else {
                    $message['type'] = $is_ajax?'error':'danger';
                    $message['text'] = 'An error occured while saving the user account';
                }
           
            }else {
                //otherwise update the user
                if(!empty($user_data['password_hash'])) {
                    $user_data['password_hash'] = do_hash($user_data['password_hash']);
                }else {
                    unset($user_data['Password']);
                } 
                $message = array();
                if($this->user_model->update_user($user_data)) {
                    $message['type'] = 'success';
                    $message['text'] = 'User account updated Successfully';
                }else {
                    $message['type'] = $is_ajax?'error':'danger';
                    $message['text'] = 'An error occured while updating the user account';
                }
            }
			
			
			if($is_ajax) {
				echo json_encode($message);
			}else {
				$this->session->set_flashdata('action_message',$message);
				redirect('settings/users');
			}
			
		}
	}
	
	/**
	* Delete the user account
	* @param int $user_id : The user account id you want to delete
	* @param bool $is_ajax : Boolean flag indicating wether the request was sent via ajax or not. Default false (Not ajax)
	**/
	function deleteUser($user_id, $is_ajax=0) {
		
        $message['type'] = 'warning';
        $message['text'] = 'You dont have a permission to delete a user';

        $this->auth->restrict($message, 'Users.Delete');

        $this->load->model('user_model');
		
		if($this->user_model->delete((int)$user_id)) {
			$message['type'] = 'success';
			$message['text'] = 'The user has been deleted!';
		}else {
			$message['type'] = ($is_ajax)?'error':'danger';
			$message['text'] = 'The user has been deleted!';
		}
		
		if($is_ajax) {
			echo json_encode($message);
		}else {
			$this->session->set_flashdata('action_message',$message);
			redirect('settings/users');
		}
	}
	
	function editUser($user_id,$is_ajax=0) {

        // Restrict access to only users with User.Edit permission (Edit users)    
        $message['type'] = 'warning';
        $message['text'] = 'You dont have a permission to edit a user';

        $this->auth->restrict($message, 'Users.Edit');

		$this->load->model('user_model');
		
		$selected_user = $this->user_model->get_user_by_id($user_id);
		$data['user'] = $selected_user;
		
		$data['ajax'] = $is_ajax;

		if($is_ajax) {
			$this->load->view('user_form',$data);
		}else {
			// SB Admin CSS - Include with every page
			$this->layout->add_css('sb-admin');
		
			// SB Admin Scripts - Include with every page
			$this->layout->add_js('sb-admin');
			$this->layout->view('user_form',$data);
		}
	}
    public function permissions() {

        // restrict access to users who have Permissions.Views 
        $message['type'] = 'warning';
        $message['text'] = 'You dont have a permission to view permissions';

        $this->auth->restrict($message, 'Permissions.View');
        // SB Admin CSS - Include with every page
        $this->layout->add_css('sb-admin');

        // SB Admin Scripts - Include with every page
        $this->layout->add_js('sb-admin');
        $this->layout->add_js('permissions');

        $this->load->model('permission_model');
        
        $permissions = $this->permission_model->get_all();
        
        $permissions_columns = array('Permission name','Permission Description','Status');

        if(has_permission('Permissions.Edit') || has_permission('Permissions.Delete')) {
            $permissions_columns[] = 'Actions';
        }
       
        $data['permissions'] = $permissions;
        $data['permissions_columns'] = $permissions_columns;
        
        $this->layout->view('permissions_list',$data);
    }

    public function createPermission($is_ajax = 0) {
        
        // restrict access to users who have Permissions.Add 
        $message['type'] = 'warning';
        $message['text'] = 'You dont have a permission to create permissions';

        $this->auth->restrict($message, 'Permissions.Add');
        $data['ajax'] = $is_ajax;

        if($is_ajax) {
            $this->load->view('permissions_form',$data);
        }else {
            // SB Admin CSS - Include with every page
            $this->layout->add_css('sb-admin');
            
            // SB Admin Scripts - Include with every page
            $this->layout->add_js('sb-admin');
            $this->layout->view('permissions_form',$data);
        }
    }

    public function deletePermission($permission_id, $is_ajax=0) { 
        
        // restrict access to users who have Permissions.Delete 
        $message['type'] = 'warning';
        $message['text'] = 'You dont have a permission to delete permissions';

        $this->auth->restrict($message, 'Permissions.Delete');
        
        $this->load->model('permission_model');
        
        $message = array();

        if($this->permission_model->delete($permission_id)) {
            $message['type'] = 'success';
            $message['text'] = 'Permission deleted Successfully';    
        }else {
            
            $message['type'] = $is_ajax?'error':'danger';
            $message['text'] = 'An error occured while deleting permission. Please try again';
        } 

        if($is_ajax) {
            return json_encode($message);
        }else {
            $this->session->set_flashdata('action_message',$message);

            redirect('settings/permissions');
        }
    }

    public function editPermission($permission_id, $is_ajax=0) {
       
        // restrict access to users who have Permissions.Edit 
        $message['type'] = 'warning';
        $message['text'] = 'You dont have a permission to edit permissions';

        $this->auth->restrict($message, 'Permissions.Edit');
        
        $this->load->model('permission_model');
        
        $data['ajax'] = $is_ajax;
        
        $permission = $this->permission_model->find($permission_id);  
        
        $data['permission'] = $permission;

          
        if($is_ajax) {
            $this->load->view('permissions_form',$data);
        }else {
            // SB Admin CSS - Include with every page
            $this->layout->add_css('sb-admin');
        
            // SB Admin Scripts - Include with every page
            $this->layout->add_js('sb-admin');
            $this->layout->view('permissions_form',$data); 
        }
    }

    public function savePermission($is_ajax=0) {
        $permission_id = $this->input->post('permission_id');
    
        $is_ajax = $this->input->post('ajax');
       
        $this->load->library('form_validation');
        
        $config = array(
            array('field'=>'name',
                  'label'=>'Permission Name',
                  'rules'=>'required'),
            array('field'=>'description',
                  'label'=>'Permission Description',
                  'rules'=>'required'),
            array('field'=>'status',
                  'label'=>'Status',
                  'rules'=>'required')
              );
        
        $this->form_validation->set_rules($config);
        
        if($this->form_validation->run()===FALSE) {
           $this->createPermission($is_ajax); 
        }else {
            $this->load->model('permission_model');
            
            $data = $this->input->post();
 
            $message = array();
            if(empty($permission_id)) {
                if($this->permission_model->save_permission($data)) {
                    $message['type'] = 'success';
                    $message['text'] = 'Permission created Successfully';
                }else {
                    $message['type'] = $is_ajax?'error':'danger';
                    $message['text'] = 'An error occured while creating permission. Please try again';
                }
            
            }else {
                
                if($this->permission_model->update_permission($data)) {
                    
                    $message['type'] = 'success';
                    $message['text'] = 'Permission updated successfully';
                }else {
                    
                    $message['type'] = $is_ajax?'error':'danger';
                    $message['text'] = 'An error occured while creating permission. Please try again';
                }
            }

            if($is_ajax) {
                echo json_encode($message);
            }else {
                $this->session->set_flashdata('action_message',$message);

                redirect('settings/permissions');
            }
        }    
        
    }

    public function roles() {
         
        // restrict access to users who have Roles.View 
        $message['type'] = 'warning';
        $message['text'] = 'You dont have a permission to view system roles';

        $this->auth->restrict($message, 'Roles.View');


        // SB Admin CSS - Include with every page
        $this->layout->add_css('sb-admin');

        // SB Admin Scripts - Include with every page
        $this->layout->add_js('sb-admin');
        $this->layout->add_js('roles');

        $this->load->model('role_model');

        $roles = $this->role_model->get_all();
        
        $roles_columns = array('Role Name','Role Description','Built In','Can Be Deleted');

        if(has_permission('Roles.Edit') || has_permission('Roles.Delete')) {
            $roles_columns[] = 'Actions';
        }

        $data['roles'] = $roles;
        $data['roles_columns'] = $roles_columns;

        $this->layout->view('roles_list',$data);
    }

    public function editRole($role_id, $is_ajax = 0) {
    
         
        // restrict access to users who have Roles.Edit 
        $message['type'] = 'warning';
        $message['text'] = 'You dont have a permission to edit system roles';

        $this->auth->restrict($message, 'Roles.Edit');
        $this->load->model('role_model');

        $data['ajax'] = $is_ajax;

        $role = $this->role_model->find($role_id);  

        $data['role'] = $role;

  
        if($is_ajax) {
            $this->load->view('role_form',$data);
        }else {
            // SB Admin CSS - Include with every page
            $this->layout->add_css('sb-admin');

            // SB Admin Scripts - Include with every page
            $this->layout->add_js('sb-admin');
            $this->layout->view('role_form',$data); 
        }
    }

    public function deleteRole($role_id, $is_ajax = 0) {
         
        // restrict access to users who have Role.Delete 
        $message['type'] = 'warning';
        $message['text'] = 'You dont have a permission to delete system roles';

        $this->auth->restrict($message, 'Roles.Delete');
        $this->load->model('role_model');

        $message = array();

        if($this->role_model->delete($role_id)) {
            $message['type'] = 'success';
            $message['text'] = 'Permission deleted Successfully';    
        }else {
    
            $message['type'] = $is_ajax?'error':'danger';
            $message['text'] = 'An error occured while deleting permission. Please try again';
        } 

        if($is_ajax) {
            return json_encode($message);
        }else {
            $this->session->set_flashdata('action_message',$message);
            
            redirect('settings/permissions');
        }
    }

    public function createRole($is_ajax=0) {
         
        // restrict access to users who have Roles.Add 
        $message['type'] = 'warning';
        $message['text'] = 'You dont have a permission to view system roles';

        $this->auth->restrict($message, 'Roles.Add');
        $data['ajax'] = $is_ajax;

        if($is_ajax) {
            $this->load->view('role_form',$data);
        }else {
            // SB Admin CSS - Include with every page
            $this->layout->add_css('sb-admin'); 
            // SB Admin Scripts - Include with every page
            $this->layout->add_js('sb-admin');
            $this->layout->view('role_form',$data);
        }
    }

    public function saveRole() {
        
        $is_ajax = $this->input->post('ajax');
        $role_id = $this->input->post('id_role');

        $this->load->library('form_validation');

        $config = array(
            array('field'=>'role_name',
                  'label'=>'Role Name',
                  'rules'=>'required'),
            array('field'=>'description',
                  'label'=>'Role Description',
                  'rules'=>'required')
        );

        $this->form_validation->set_rules($config);

        if($this->form_validation->run()===FALSE) {
            $this->createRole($is_ajax);
        }else {
        
            $this->load->model('role_model');
            
            $data = $this->input->post();
            $data['can_delete'] = isset($data['can_delete']); 
            $message = array();
            if(empty($role_id)) {
                if($this->role_model->save_role($data)) {
                    $message['type'] = 'success';
                    $message['text'] = 'Role created Successfully';
                }else {
                    $message['type'] = $is_ajax?'error':'danger';
                    $message['text'] = 'An error occured while creating role. Please try again';
                }
            
            }else {
                
                if($this->role_model->update_role($data)) {
                    
                    $message['type'] = 'success';
                    $message['text'] = 'Role updated successfully';
                }else {
                    
                    $message['type'] = $is_ajax?'error':'danger';
                    $message['text'] = 'An error occured while updating role. Please try again';
                }
            }

            if($is_ajax) {
                echo json_encode($message);
            }else {
                $this->session->set_flashdata('action_message',$message);

                redirect('settings/roles');
            } 
        }
    }
        
    public function rolePermissions() {
        
        // restrict access to users who have Permissions.Manage 
        $message['type'] = 'warning';
        $message['text'] = 'You dont have a permission to manage system permissions';

        $this->auth->restrict($message, 'Permissions.Manage');
        // SB Admin CSS - Include with every page
        $this->layout->add_css('sb-admin');

        // SB Admin Scripts - Include with every page
        $this->layout->add_js('sb-admin');
        $this->layout->add_js('roles_permissions');
        
        $this->load->model(array('role_permission_model','role_model','permission_model'));
        
        // get all roles not deleted 
        $roles = $this->role_model->get_all(array('deleted'=>0)); 

        //get all permissions not deleted
        $permissions = $this->permission_model->get_all();


        $roles_permissions = $this->role_permission_model->find_all_roles_permissions();  
        
        $current_permissions = array();

        foreach($roles_permissions as $rp) {

            $current_permissions[] = $rp->role_id.','.$rp->permission_id;

        }

        $data['roles'] = $roles;
        $data['role_permissions'] = $roles_permissions;
        $data['permissions'] = $permissions;
        $data['permissions_values'] = $current_permissions;

        //$this->layout->view('rolePermissions');
        $this->layout->view('rolePermissions',$data); 
        
    }

    function saveRolePermissions($is_ajax = 0) {
        
        // restrict access to users who have Permissions.Manage 
        $message['type'] = 'warning';
        $message['text'] = 'You dont have a permission to manage system permissions';

        $this->auth->restrict($message, 'Permissions.Manage');
        
        $message = array();

        $this->load->model('role_permission_model');

        $data = $this->input->post('permissions');
        
        $permissions = array();
        
    
        foreach($data as $p) {
            $role_permission= explode(',',$p);
            $role_permission['role_id'] = $role_permission[0];
            $role_permission['permission_id'] = $role_permission[1];            
            unset($role_permission[0]);
            unset($role_permission[1]);
        
            $permissions[] = $role_permission;    
        }

       
        $this->role_permission_model->delete();
            
        if($this->role_permission_model->save_all($permissions)) {
            $message['type'] = 'success';
            $message['text'] = 'Role Permissions saved successfully';
        }else {
                
                $message['type'] = $is_ajax?'error':'danger';
                $message['text'] = 'An error occured while saving permissions.';
       }

       if($is_ajax) {
           echo json_encode($data); 
        }else {
            $this->session->set_flashdata('action_message',$message);
            redirect('settings/rolePermissions');    
        } 
    }

}
