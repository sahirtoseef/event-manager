<?php

namespace App\Helpers;

use App\User;
use  Illuminate\Support\Carbon;
use DateTime;
use Illuminate\Support\Facades\Session;

class Helper
{
    public static function saveFileToFolder($request, $file_type)
    {
        if ($request->hasfile($file_type)) {
            $file = $request->file($file_type);
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move(public_path('img/userImages'), $filename);
            return $filename;
        } else {
            return '';
        }
    }

    public static function generateRandomPassword($length = 16)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function differenceBetweenTwoNumbers($previous, $current)
    {
        $array = array('colorType' => 'greenColor');
        if ($previous != $current) {
            if ($previous) {
                $result = (($current - $previous) / $previous) * 100;
                if ($result < 0) {
                    $result = abs($result);
                    $array['colorType'] = 'redColor';
                }
                $result = round($result, 2);
                $result = $result . "%";
                $array['percentage'] =  $result;
            } else {
                $array['colorType'] = 'greenColor';
                $per = $current * 100;
                $array['percentage'] =  $per . '%';
            }
        } else {
            $array['colorType'] = 'yellowColor';
            $array['percentage'] =  '0%';
        }
        return $array;
    }

    public static function getCurrentWeekClients($className)
    {
        $now = Carbon::now();
        $weekStart = $now->subDays($now->dayOfWeek)->setTime(0, 0);
        return $className::where('created_at', '>=', $weekStart)->where('role_id', '=', 3)->count();
    }
    public static function getPreviousWeekClients($className)
    {
        $currentWeek = Carbon::now()->startOfWeek();
        $previousWeek = Carbon::now()->startOfWeek()->subDay(7);
        return $className::where('role_id', '=', 3)->whereBetween('created_at', array($previousWeek, $currentWeek))->count();
    }

    public static function buildGraphData($events)
    {
        $arrayData = array();
        $currentMonth = date("n");
        foreach ($events as $event) {
            $monthName = Helper::getMonthName($event->created_at);
            if (array_key_exists($monthName, $arrayData)) {
                $arrayData[$monthName] = $arrayData[$monthName] + count($event->visitors);
            } else {
                $arrayData[$monthName] = count($event->visitors);
            }
        }
        $response = Helper::fillUpMissingMonths($currentMonth, $arrayData);
        $finalGraphData = array();
        $finalGraphData['X_AXIS'] = array_keys($response);
        $finalGraphData['Y_AXIS'] = array_values($response);
        return $finalGraphData;
    }

    public static function getMonthName($date)
    {
        $timestamp = strtotime($date);
        return  date('M', $timestamp);
    }

    public static function fillUpMissingMonths($currentMonth, $data)
    {
        $array = array();
        $month = [
            "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
        ];
        for ($i = 0; $i < count($month); $i++) {
            if ($currentMonth > $i) {
                if (array_key_exists($month[$i], $data)) {
                    $array[$month[$i]] = $data[$month[$i]];
                } else {
                    $array[$month[$i]] = 0;
                }
            } else {
                break;
            }
        }
        return $array;
    }

    public static function getPeakHoursFromData($data)
    {
        $peakHoursData = Helper::getPeakHourStaticData();
        foreach ($data as $record) {
            if ($record->checkin_time) {
                $hourData = Helper::getHourFromDate($record->checkin_time);
                if ($hourData) {
                    $explodedHour = explode('-', $hourData);
                    foreach ($peakHoursData as $key => $value) {
                        $explodedStaticKey = explode(' ', $key);
                        $explodedStaticKeyHour = explode('-', $explodedStaticKey[0]);
                        if ($explodedHour[1] == 'AM' && $explodedStaticKey[1] == 'AM') {
                            if ($explodedHour[0] == 12 || $explodedHour[0] == 1 || $explodedHour[0] == 2) {
                                $peakHoursData['12-2 AM'] += 1;
                                break;
                            } else {
                                if ($explodedHour[0] >= $explodedStaticKeyHour[0] && $explodedHour[0] <= $explodedStaticKeyHour[1]) {
                                    $peakHoursData[$key] += 1;
                                    break;
                                }
                            }
                        } else if ($explodedHour[1] == 'PM' && $explodedStaticKey[1] == 'PM') {
                            if ($explodedHour[0] == 12 || $explodedHour[0] == 1 || $explodedHour[0] == 2) {
                                $peakHoursData['12-2 PM'] += 1;
                                break;
                            } else
                            if ($explodedHour[0] >= $explodedStaticKeyHour[0] && $explodedHour[0] <= $explodedStaticKeyHour[1]) {
                                $peakHoursData[$key] += 1;
                                break;
                            }
                        }
                    }
                }
            }
        }
        return $peakHoursData;
    }
    public static function getHourFromDate($date)
    {
        $hour = explode(':', explode(' ', $date)[1])[0];
        if ($hour >= 12) {
            $timeType = 'PM';
            return ($hour - 12) ? ($hour - 12) . '-' . $timeType : '12-' . $timeType;
        } else {
            $timeType = 'AM';
            return ($hour) ? $hour . '-' . $timeType : '12-' . $timeType;
        }
        return false;
    }
    public static function getPeakHourStaticData()
    {
        return array(
            '12-2 AM' => 0, '3-5 AM' => 0, '6-8 AM' => 0,
            '9-11 AM' => 0, '12-2 PM' => 0, '3-5 PM' => 0, '6-8 PM' => 0, '9-11 PM' => 0
        );
    }
    
    public  static  function setSessionData($event_id)
    {
        $event = Event::find($event_id);
        Session::put("event_id", $event_id);
        Session::put("title", $event->title);
        Session::save();
    }
    public  static  function getSessionData()
    {
        return (Session::get('event_id')) ? Session::get('event_id') : 0;
    }
}
