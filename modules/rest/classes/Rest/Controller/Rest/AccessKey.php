<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Gallery - a web based photo album viewer and editor
 * Copyright (C) 2000-2013 Bharat Mediratta
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street - Fifth Floor, Boston, MA  02110-1301, USA.
 */
class Rest_Controller_Rest_AccessKey extends Controller_Rest {
  public function check_auth($auth) {
    // Check login using "user" and "password" fields in POST.  Fire a 403 Forbidden if it fails.
    if (!Validation::factory($this->request->post())
      ->rule("user", "Auth::validate_login", array(":validation", ":data", "user", "password"))
      ->check()) {
      throw Rest_Exception::factory(403);
    }

    // Set the access key
    $this->request->headers("x-gallery-request-key", Rest::access_key());

    return parent::check_auth($auth);
  }

  public function action_post() {
    // If we got here, login was already successful - simply return the key.
    $this->reply = Rest::access_key();
  }
}