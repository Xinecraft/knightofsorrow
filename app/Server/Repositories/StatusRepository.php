<?php
/**
 * 
 * Copyright (c) 2014 Zishan Ansari
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * Date: 8/2/2015
 * Time: 12:39 AM
 */

namespace App\Server\Repositories;

use App\Status;
use Auth;
use App\User;

class StatusRepository {

    public function getFeedsForUser(User $user)
    {
        $userIds = $user->following()->lists('followed_id');
        $userIds[] = $user->id;

        return Status::whereIn('user_id', $userIds)->with('comments','user')->latest();
    }

    public function publish($status)
    {
        return Auth::user()->statuses()->create($status);
    }

    public function find($id)
    {
        return Status::findOrFail($id);
    }

    /**
     * Find and return a Status only if current user is Owner.
     *
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function findOnlyIfOwner($id)
    {
        $status = Status::findOrFail($id);

        if(Auth::user() == $status->user)
            return $status;
        else
            throw new \Exception("Not an Owner");
    }

}