<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$data = get_user_meta(get_current_user_id());

$html .= '<div class="wpneo-content">';    
    $html .= '<form id="wpneo-dashboard-form" action="" method="" class="wpneo-form">';
        $html .= '<div class="wpneo-row">';


                    $html .= '<div class="wpneo-col6">';
                        $html .= '<div class="wpneo-shadow wpneo-padding25 wpneo-clearfix">';
                            $html .= '<h4>'.__("Profile Picture","wp-crowdfunding").'</h4>';
                            $html .= '<div class="wpneo-fields">';
                            $html .= '<input type="hidden" name="action" value="wpneo_profile_form">';
                                $img_src = '';
                                $image_id = get_user_meta( get_current_user_id(), 'profile_image_id', true );
                                if( $image_id != '' ){
                                    $img_src = wp_get_attachment_image_src( $image_id, 'full' )[0];
                                }
                                $html .= '<img class="profile-form-img" src="'.$img_src.'" alt="'.__( "Profile Image:" , "wp-crowdfunding" ).'">';
                                $html .= '<span id="wpneo-image-show"></span>';
                                //$html .= '<input type="text" name="wpneo-form-image-url" class="wpneo-upload wpneo-form-image-url" value="'.$img_src.'" disabled>';
                                $html .= '<input type="hidden" name="profile_image_id" class="wpneo-form-image-id" value="'.$image_id.'">';
                                $html .= '<input type="hidden" name="wpneo-form-image-url" class="wpneo-form-image-url" value="'.$image_id.'">';
                                $html .= '<button name="wpneo-upload" id="cc-image-upload-file-button" class="wpneo-image-upload float-right">'.__( "Upload" , "wp-crowdfunding" ).'</button>';
                            $html .= '</div>';
                        $html .= '</div>';//wpneo-shadow 
                    $html .= '</div>';//wpneo-col6

                    $html .= '<div class="wpneo-col6">';  
                        $html .= '<div class="wpneo-shadow wpneo-padding25 wpneo-clearfix">';  
                            $html .= '<h4>'.__("Basic Info","wp-crowdfunding").'</h4>';
                            $html .= '<div class="wpneo-name">';
                                $html .= '<p>'.__( "About Us:" , "wp-crowdfunding" ).'</p>';
                            $html .= '</div>';
                            $html .= '<div class="wpneo-fields float-right">';
                                $value = ''; if(isset($data['profile_about'][0])){ $value = esc_textarea($data['profile_about'][0]); }
                                $html .= '<textarea name="profile_about" rows="3" disabled>'.$value.'</textarea>';
                            $html .= '</div>';

                            // Profile Information
                            $html .= '<div class="wpneo-single">';
                                $html .= '<div class="wpneo-name">';
                                    $html .= '<p>'.__( "Profile Info:" , "wp-crowdfunding" ).'</p>';
                                $html .= '</div>';
                                $html .= '<div class="wpneo-fields float-right">';
                                    $value = ''; if(isset($data['profile_portfolio'][0])){ $value = esc_textarea($data['profile_portfolio'][0]); }
                                    $html .= '<textarea name="profile_portfolio" rows="3" disabled>'.$value.'</textarea>';
                                $html .= '</div>';
                            $html .= '</div>';
                        $html .= '</div>';//wpneo-shadow 
                    $html .= '</div>';//wpneo-col6 



            // Mobile Number
            $html .= '<div class="wpneo-col6">';
                $html .= '<div class="wpneo-shadow wpneo-padding25 wpneo-clearfix">';
                    $html .= '<h4>'.__("Contact Info","wp-crowdfunding").'</h4>';
                    $html .= '<div class="wpneo-single">';
                        $html .= '<div class="wpneo-name">';
                            $html .= '<p>'.__( "Mobile Number:" , "wp-crowdfunding" ).'</p>';
                        $html .= '</div>';
                    $html .= '</div>';
                    $html .= '<div class="wpneo-fields float-right">';
                        $value = ''; if(isset($data['profile_mobile1'][0])){ $value = esc_attr($data['profile_mobile1'][0]); }
                        $html .= '<input type="text" name="profile_mobile1" value="'.$value.'" disabled>';
                    $html .= '</div>';
                    // Email
                    $html .= '<div class="wpneo-single">';
                        $html .= '<div class="wpneo-name">';
                            $html .= '<p>'.__( "Email:" , "wp-crowdfunding" ).'</p>';
                        $html .= '</div>';
                        $html .= '<div class="wpneo-fields float-right">';
                            $value = ''; if(isset($data['profile_email1'][0])){ $value = esc_attr($data['profile_email1'][0]); }
                            $html .= '<input type="text" name="profile_email1" value="'.$value.'" disabled>';
                        $html .= '</div>';
                    $html .= '</div>';
                    // Fax
                    $html .= '<div class="wpneo-single">';
                        $html .= '<div class="wpneo-name">';
                            $html .= '<p>'.__( "Fax:" , "wp-crowdfunding" ).'</p>';
                        $html .= '</div>';
                        $html .= '<div class="wpneo-fields float-right">';
                            $value = ''; if(isset($data['profile_fax'][0])){ $value = esc_attr($data['profile_fax'][0]); }
                            $html .= '<input type="text" name="profile_fax" value="'.$value.'" disabled>';
                        $html .= '</div>';
                    $html .= '</div>';
                    // Website
                    $html .= '<div class="wpneo-single">';
                        $html .= '<div class="wpneo-name">';
                            $html .= '<p>'.__( "Website:" , "wp-crowdfunding" ).'</p>';
                        $html .= '</div>';
                        $html .= '<div class="wpneo-fields float-right">';
                            $value = ''; if(isset($data['profile_website'][0])){ $value = esc_url($data['profile_website'][0]); }
                            $html .= '<input type="text" name="profile_website" value="'.$value.'" disabled>';
                        $html .= '</div>';
                    $html .= '</div>';

                    // Address
                    $html .= '<div class="wpneo-single">';
                        $html .= '<div class="wpneo-name">';
                            $html .= '<p>'.__( "Address:" , "wp-crowdfunding" ).'</p>';
                        $html .= '</div>';
                        $html .= '<div class="wpneo-fields float-right">';
                            $value = ''; if(isset($data['profile_address'][0])){ $value = esc_textarea($data['profile_address'][0]); }
                            $html .= '<input type="text" name="profile_address" value="'.$value.'" disabled>';
                        $html .= '</div>';
                    $html .= '</div>';
                $html .= '</div>';//wpneo-shadow 
            $html .= '</div>';//wpneo-col6

            $html .= '<div class="wpneo-col6">';
                $html .= '<div class="wpneo-shadow wpneo-padding25 wpneo-clearfix">';
                    $html .= '<h4>'.__("Social Profile","wp-crowdfunding").'</h4>';
                    //Facebook
                    $html .= '<div class="wpneo-single">';
                        $html .= '<div class="wpneo-name">';
                            $html .= '<p>'.__( "Facebook:" , "wp-crowdfunding" ).'</p>';
                        $html .= '</div>';
                        $html .= '<div class="wpneo-fields">';
                            $value = ''; if(isset($data['profile_facebook'][0])){ $value = esc_textarea($data['profile_facebook'][0]); }
                            $html .= '<input type="text" name="profile_facebook" value="'.$value.'" disabled>';
                        $html .= '</div>';
                    $html .= '</div>';

                    // Twitter
                    $html .= '<div class="wpneo-single">';
                        $html .= '<div class="wpneo-name float-left">';
                            $html .= '<p>'.__( "Twitter:" , "wp-crowdfunding" ).'</p>';
                        $html .= '</div>';
                        $html .= '<div class="wpneo-fields">';
                            $value = ''; if(isset($data['profile_twitter'][0])){ $value = esc_textarea($data['profile_twitter'][0]); }
                            $html .= '<input type="text" name="profile_twitter" value="'.$value.'" disabled>';
                        $html .= '</div>';
                    $html .= '</div>';
                    
                    // Google Plus
                    $html .= '<div class="wpneo-single">';
                        $html .= '<div class="wpneo-name">';
                            $html .= '<p>'.__( "Google Plus:" , "wp-crowdfunding" ).'</p>';
                        $html .= '</div>';
                        $html .= '<div class="wpneo-fields float-right">';
                            $value = ''; if(isset($data['profile_plus'][0])){ $value = esc_textarea($data['profile_plus'][0]); }
                            $html .= '<input type="text" name="profile_plus" value="'.$value.'" disabled>';
                        $html .= '</div>';
                    $html .= '</div>';

                    // Linkedin
                    $html .= '<div class="wpneo-single">';
                        $html .= '<div class="wpneo-name">';
                            $html .= '<p>'.__( "Linkedin:" , "wp-crowdfunding" ).'</p>';
                        $html .= '</div>';
                        $html .= '<div class="wpneo-fields float-right">';
                            $value = ''; if(isset($data['profile_linkedin'][0])){ $value = esc_textarea($data['profile_linkedin'][0]); }
                            $html .= '<input type="text" name="profile_linkedin" value="'.$value.'" disabled>';
                        $html .= '</div>';
                    $html .= '</div>';

                    // Pinterest
                    $html .= '<div class="wpneo-single">';
                        $html .= '<div class="wpneo-name">';
                            $html .= '<p>'.__( "Pinterest:" , "wp-crowdfunding" ).'</p>';
                        $html .= '</div>';
                        $html .= '<div class="wpneo-fields float-right">';
                            $value = ''; if(isset($data['profile_pinterest'][0])){ $value = esc_textarea($data['profile_pinterest'][0]); }
                            $html .= '<input type="text" name="profile_pinterest" value="'.$value.'" disabled>';
                        $html .= '</div>';
                    $html .= '</div>';
                $html .= '</div>';//wpneo-shadow 
            $html .= '</div>';//wpneo-col6
        $html .= '</div>';//wpneo-row

        ob_start();
        do_action('wpneo_crowdfunding_dashboard_after_profile_form');
        $html .= ob_get_clean();

        $html .= wp_nonce_field( 'wpneo_crowdfunding_dashboard_form_action', 'wpneo_crowdfunding_dashboard_nonce_field', true, false );

        //Save Button
        $html .= '<div class="wpneo-buttons-group float-right">';
            $html .= '<button id="wpneo-edit" class="wpneo-edit-btn">'.__( "Edit" , "wp-crowdfunding" ).'</button>';
$html .= '<button id="wpneo-dashboard-btn-cancel" class="wpneo-cancel-btn wpneo-hidden" type="submit">'.__( "Cancel" , "wp-crowdfunding" ).'</button>';
            $html .= '<button id="wpneo-profile-save" class="wpneo-save-btn wpneo-hidden" type="submit">'.__( "Save" , "wp-crowdfunding" ).'</button>';
        $html .= '</div>';
        $html .= '<div class="clear-float"></div>';

    $html .= '</form>';
$html .= '</div>';