<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Libraries\Mtlib;

class Filterauth implements FilterInterface
{
    function __construct()
    {
        helper(['cookie', 'web', 'array', 'filesystem']);
        // $this->_db      = \Config\Database::connect();
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        $jwt = get_cookie('jwt');
        $token_jwt = getenv('token_jwt.default.key');
        if ($jwt) {
            try {
                $decoded = JWT::decode($jwt, new Key($token_jwt, 'HS256'));
                if ($decoded) {
                    $userId = $decoded->id;
                    $level = $decoded->level;

                    $uri = current_url(true);
                    $totalSegment = $uri->getTotalSegments();
                    if ($totalSegment > 0) {
                        $uriMain = $uri->getSegment(1);
                        if ($uriMain === "" || $uriMain === "home" || $uriMain === "auth" || $uriMain === "portal" || $uriMain === "profil") {
                        } else {
                            if ($uriMain === "su") {
                                $uriLevel = $uri->getSegment(1);
                                $mtLib = new Mtlib();
                                if ($mtLib->get()) {
                                    if (!$mtLib->getAccess($userId)) {
                                        if ($uriLevel !== "maintenance") {
                                            return redirect()->to(base_url('maintenance'));
                                        }
                                    } else {

                                        if ($level == 1) { //SuperAdmin

                                            if ($uriLevel === "" || $uriLevel === "index") {
                                                return redirect()->to(base_url('su/home'));
                                            }
                                            if ($uriLevel != "su") {
                                                return redirect()->to(base_url('su/home'));
                                            }
                                        } else if ($level == 2) { //Peng
                                            if ($uriLevel === "" || $uriLevel === "index") {
                                                return redirect()->to(base_url('peng/home'));
                                            }
                                            if ($uriLevel != "peng") {
                                                return redirect()->to(base_url('peng/home'));
                                            }
                                        } else if ($level == 3) { //Adm
                                            if ($uriLevel === "" || $uriLevel === "index") {
                                                return redirect()->to(base_url('adm/home'));
                                            }
                                            if ($uriLevel != "adm") {
                                                return redirect()->to(base_url('adm/home'));
                                            }
                                        } else if ($level == 4) { //Kepala
                                            if ($uriLevel === "" || $uriLevel === "index") {
                                                return redirect()->to(base_url('kepala/home'));
                                            }
                                            if ($uriLevel != "adm") {
                                                return redirect()->to(base_url('kepala/home'));
                                            }
                                        } else if ($level == 5) { //Operator
                                            if ($uriLevel === "" || $uriLevel === "index") {
                                                return redirect()->to(base_url('operator/home'));
                                            }
                                            if ($uriLevel != "operator") {
                                                return redirect()->to(base_url('operator/home'));
                                            }
                                        } else if ($level == 6) { //Operator
                                            if ($uriLevel === "" || $uriLevel === "index") {
                                                return redirect()->to(base_url('peksos/home'));
                                            }
                                            if ($uriLevel != "peksos") {
                                                return redirect()->to(base_url('peksos/home'));
                                            }
                                        } else {
                                            return redirect()->to(base_url('portal'));
                                        }
                                    }
                                } else {

                                    if ($level == 1) { //SuperAdmin

                                        if ($uriLevel === "" || $uriLevel === "index") {
                                            return redirect()->to(base_url('su/home'));
                                        }
                                        if ($uriLevel != "su") {
                                            return redirect()->to(base_url('su/home'));
                                        }
                                        // else {
                                        //     var_dump($uriLevel);
                                        //     die;
                                        //     $uriMainMenu = $uri->getSegment(3);
                                        //     if ($uriLevel === "su" && $uriMainMenu === "home") {
                                        //     } else {

                                        //         $dataAccess = listHakAksesAllow();
                                        //         if (!$dataAccess) {
                                        //             return redirect()->to(base_url('a/home'));
                                        //         }

                                        //         if (!(menu_showed_access($dataAccess, $uriMainMenu))) {
                                        //             return redirect()->to(base_url('a/home'));
                                        //         }

                                        //         $uriMainSubMenu = $uri->getSegment(3);

                                        //         if (!(submenu_showed_access($dataAccess, $uriMainMenu, $uriMainSubMenu))) {
                                        //             return redirect()->to(base_url('a/notallow'));
                                        //             // return redirect()->to(base_url('a/home'));
                                        //         }

                                        //         $uriMainSubMenuAksi = $uri->getSegment(4);

                                        //         if (!(access_allowed_new($dataAccess, $uriMainMenu, $uriMainSubMenu, $uriMainSubMenuAksi))) {
                                        //             if ($uriMainSubMenuAksi == "" || $uriMainSubMenuAksi == "data") {
                                        //                 return redirect()->to(base_url('a/notallow'));
                                        //             } else {
                                        //                 $response = new \stdClass;
                                        //                 $response->status = 400;
                                        //                 $response->message = "Akses tidak diizinkan.";
                                        //                 return json_encode($response);
                                        //             }
                                        //         }

                                        //         // if (!(access_allowed($dataAccess, $uriMainMenu, $uriMainSubMenu))) {
                                        //         //     return redirect()->to(base_url('a/notallow'));
                                        //         // }
                                        //     }
                                        // }
                                    } else if ($level == 2) { //Admin
                                        if ($uriLevel === "" || $uriLevel === "index") {
                                            return redirect()->to(base_url('peng/home'));
                                        }
                                        if ($uriLevel != "peng") {
                                            return redirect()->to(base_url('peng/home'));
                                        }
                                        // if ($uriMain != "b") {
                                        //     return redirect()->to(base_url('b/home'));
                                        // } else {
                                        //     $uriMainMenu = $uri->getSegment(2);
                                        //     if ($uriMain == "a" && $uriMainMenu == "home") {
                                        //     } else {

                                        //         $dataAccess = listHakAksesAllow();
                                        //         if (!$dataAccess) {
                                        //             return redirect()->to(base_url('a/home'));
                                        //         }

                                        //         if (!(menu_showed_access($dataAccess, $uriMainMenu))) {
                                        //             return redirect()->to(base_url('a/home'));
                                        //         }

                                        //         $uriMainSubMenu = $uri->getSegment(3);

                                        //         if (!(submenu_showed_access($dataAccess, $uriMainMenu, $uriMainSubMenu))) {
                                        //             return redirect()->to(base_url('a/notallow'));
                                        //             // return redirect()->to(base_url('a/home'));
                                        //         }

                                        //         $uriMainSubMenuAksi = $uri->getSegment(4);

                                        //         if (!(access_allowed_new($dataAccess, $uriMainMenu, $uriMainSubMenu, $uriMainSubMenuAksi))) {
                                        //             if ($uriMainSubMenuAksi == "" || $uriMainSubMenuAksi == "data") {
                                        //                 return redirect()->to(base_url('a/notallow'));
                                        //             } else {
                                        //                 $response = new \stdClass;
                                        //                 $response->status = 400;
                                        //                 $response->message = "Akses tidak diizinkan.";
                                        //                 return json_encode($response);
                                        //             }
                                        //         }

                                        //         // if (!(access_allowed($dataAccess, $uriMainMenu, $uriMainSubMenu))) {
                                        //         //     return redirect()->to(base_url('a/notallow'));
                                        //         // }
                                        //     }
                                        // }
                                    } else if ($level == 3) { //Kecamatan
                                        if ($uriLevel === "" || $uriLevel === "index") {
                                            return redirect()->to(base_url('adm/home'));
                                        }
                                        if ($uriLevel != "adm") {
                                            return redirect()->to(base_url('adm/home'));
                                        }
                                        // else {
                                        //     $uriMainMenu = $uri->getSegment(3);
                                        //     if ($uriLevel == "opk" && $uriMainMenu == "home") {
                                        //     } else {
                                        //         $dataAccess = listHakAksesAllow();
                                        //         if (!$dataAccess) {
                                        //             return redirect()->to(base_url('situgu/opk/home'));
                                        //         }

                                        //         if (!(menu_showed_access($dataAccess, $uriMainMenu))) {
                                        //             return redirect()->to(base_url('situgu/opk/home'));
                                        //         }

                                        //         $uriMainSubMenu = $uri->getSegment(4);

                                        //         if (!(submenu_showed_access($dataAccess, $uriMainMenu, $uriMainSubMenu))) {
                                        //             return redirect()->to(base_url('situgu/opk/notallow'));
                                        //             // return redirect()->to(base_url('a/home'));
                                        //         }

                                        //         $uriMainSubMenuAksi = $uri->getSegment(5);

                                        //         if (!(access_allowed_new($dataAccess, $uriMainMenu, $uriMainSubMenu, $uriMainSubMenuAksi))) {
                                        //             if ($uriMainSubMenuAksi == "" || $uriMainSubMenuAksi == "data") {
                                        //                 return redirect()->to(base_url('situgu/opk/notallow'));
                                        //             } else {
                                        //                 $response = new \stdClass;
                                        //                 $response->status = 400;
                                        //                 $response->message = "Akses tidak diizinkan.";
                                        //                 return json_encode($response);
                                        //             }
                                        //         }
                                        //     }
                                        // }
                                    } else if ($level == 4) { //Kepala
                                        if ($uriLevel === "" || $uriLevel === "index") {
                                            return redirect()->to(base_url('kepala/home'));
                                        }
                                        if ($uriLevel != "kepala") {
                                            return redirect()->to(base_url('kepala/home'));
                                        }
                                        // else {
                                        //     $uriMainMenu = $uri->getSegment(3);
                                        //     if ($uriLevel == "opk" && $uriMainMenu == "home") {
                                        //     } else {
                                        //         $dataAccess = listHakAksesAllow();
                                        //         if (!$dataAccess) {
                                        //             return redirect()->to(base_url('situgu/opk/home'));
                                        //         }

                                        //         if (!(menu_showed_access($dataAccess, $uriMainMenu))) {
                                        //             return redirect()->to(base_url('situgu/opk/home'));
                                        //         }

                                        //         $uriMainSubMenu = $uri->getSegment(4);

                                        //         if (!(submenu_showed_access($dataAccess, $uriMainMenu, $uriMainSubMenu))) {
                                        //             return redirect()->to(base_url('situgu/opk/notallow'));
                                        //             // return redirect()->to(base_url('a/home'));
                                        //         }

                                        //         $uriMainSubMenuAksi = $uri->getSegment(5);

                                        //         if (!(access_allowed_new($dataAccess, $uriMainMenu, $uriMainSubMenu, $uriMainSubMenuAksi))) {
                                        //             if ($uriMainSubMenuAksi == "" || $uriMainSubMenuAksi == "data") {
                                        //                 return redirect()->to(base_url('situgu/opk/notallow'));
                                        //             } else {
                                        //                 $response = new \stdClass;
                                        //                 $response->status = 400;
                                        //                 $response->message = "Akses tidak diizinkan.";
                                        //                 return json_encode($response);
                                        //             }
                                        //         }
                                        //     }
                                        // }
                                    } else if ($level == 5) { //Operator
                                        if ($uriLevel === "" || $uriLevel === "index") {
                                            return redirect()->to(base_url('operator/home'));
                                        }
                                        if ($uriLevel != "operator") {
                                            return redirect()->to(base_url('operator/home'));
                                        }
                                        // else {
                                        //     $uriMainMenu = $uri->getSegment(3);
                                        //     if ($uriLevel == "opk" && $uriMainMenu == "home") {
                                        //     } else {
                                        //         $dataAccess = listHakAksesAllow();
                                        //         if (!$dataAccess) {
                                        //             return redirect()->to(base_url('situgu/opk/home'));
                                        //         }

                                        //         if (!(menu_showed_access($dataAccess, $uriMainMenu))) {
                                        //             return redirect()->to(base_url('situgu/opk/home'));
                                        //         }

                                        //         $uriMainSubMenu = $uri->getSegment(4);

                                        //         if (!(submenu_showed_access($dataAccess, $uriMainMenu, $uriMainSubMenu))) {
                                        //             return redirect()->to(base_url('situgu/opk/notallow'));
                                        //             // return redirect()->to(base_url('a/home'));
                                        //         }

                                        //         $uriMainSubMenuAksi = $uri->getSegment(5);

                                        //         if (!(access_allowed_new($dataAccess, $uriMainMenu, $uriMainSubMenu, $uriMainSubMenuAksi))) {
                                        //             if ($uriMainSubMenuAksi == "" || $uriMainSubMenuAksi == "data") {
                                        //                 return redirect()->to(base_url('situgu/opk/notallow'));
                                        //             } else {
                                        //                 $response = new \stdClass;
                                        //                 $response->status = 400;
                                        //                 $response->message = "Akses tidak diizinkan.";
                                        //                 return json_encode($response);
                                        //             }
                                        //         }
                                        //     }
                                        // }
                                    } else if ($level == 6) { //Peksos
                                        if ($uriLevel === "" || $uriLevel === "index") {
                                            return redirect()->to(base_url('peksos/home'));
                                        }
                                        if ($uriLevel != "peksos") {
                                            return redirect()->to(base_url('peksos/home'));
                                        }
                                        // else {
                                        //     $uriMainMenu = $uri->getSegment(3);
                                        //     if ($uriLevel == "opk" && $uriMainMenu == "home") {
                                        //     } else {
                                        //         $dataAccess = listHakAksesAllow();
                                        //         if (!$dataAccess) {
                                        //             return redirect()->to(base_url('situgu/opk/home'));
                                        //         }

                                        //         if (!(menu_showed_access($dataAccess, $uriMainMenu))) {
                                        //             return redirect()->to(base_url('situgu/opk/home'));
                                        //         }

                                        //         $uriMainSubMenu = $uri->getSegment(4);

                                        //         if (!(submenu_showed_access($dataAccess, $uriMainMenu, $uriMainSubMenu))) {
                                        //             return redirect()->to(base_url('situgu/opk/notallow'));
                                        //             // return redirect()->to(base_url('a/home'));
                                        //         }

                                        //         $uriMainSubMenuAksi = $uri->getSegment(5);

                                        //         if (!(access_allowed_new($dataAccess, $uriMainMenu, $uriMainSubMenu, $uriMainSubMenuAksi))) {
                                        //             if ($uriMainSubMenuAksi == "" || $uriMainSubMenuAksi == "data") {
                                        //                 return redirect()->to(base_url('situgu/opk/notallow'));
                                        //             } else {
                                        //                 $response = new \stdClass;
                                        //                 $response->status = 400;
                                        //                 $response->message = "Akses tidak diizinkan.";
                                        //                 return json_encode($response);
                                        //             }
                                        //         }
                                        //     }
                                        // }
                                    } else {
                                        return redirect()->to(base_url('portal'));
                                    }
                                }
                            } else if ($uriMain === "situpeng") {
                                $uriLevel = $uri->getSegment(2);
                                $mtLib = new Mtlib();
                                if ($mtLib->get(2)) {
                                    if (!$mtLib->getAccess($userId)) {
                                        if ($uriLevel !== "maintenance") {
                                            return redirect()->to(base_url('situpeng/maintenance'));
                                        }
                                    } else {
                                        if ($level == 1) { //SuperAdmin

                                            if ($uriLevel === "" || $uriLevel === "index") {
                                                return redirect()->to(base_url('situpeng/su/home'));
                                            }
                                            if ($uriLevel != "su") {
                                                return redirect()->to(base_url('situpeng/su/home'));
                                            }
                                        } else if ($level == 2) { //Admin
                                            if ($uriLevel === "" || $uriLevel === "index") {
                                                return redirect()->to(base_url('situpeng/adm/home'));
                                            }
                                            if ($uriLevel != "adm") {
                                                return redirect()->to(base_url('situpeng/adm/home'));
                                            }
                                        } else if ($level == 8) { //PTK
                                            if ($uriLevel != "peng") {
                                                return redirect()->to(base_url('situpeng/peng/home'));
                                            }
                                        } else {
                                            return redirect()->to(base_url('portal'));
                                        }
                                    }
                                } else {
                                    if ($level == 1) { //SuperAdmin

                                        if ($uriLevel === "" || $uriLevel === "index") {
                                            return redirect()->to(base_url('situpeng/su/home'));
                                        }
                                        if ($uriLevel != "su") {
                                            return redirect()->to(base_url('situpeng/su/home'));
                                        }
                                    } else if ($level == 2) { //Admin
                                        if ($uriLevel === "" || $uriLevel === "index") {
                                            return redirect()->to(base_url('situpeng/adm/home'));
                                        }
                                        if ($uriLevel != "adm") {
                                            return redirect()->to(base_url('situpeng/adm/home'));
                                        }
                                    } else if ($level == 8) { //PTK
                                        if ($uriLevel != "peng") {
                                            return redirect()->to(base_url('situpeng/peng/home'));
                                        }
                                    } else {
                                        return redirect()->to(base_url('portal'));
                                    }
                                }
                            } else {
                                return redirect()->to(base_url('portal'));
                            }
                        }
                    } else {
                        return redirect()->to(base_url('portal'));
                    }
                } else {
                    $uri = current_url(true);
                    $totalSegment = $uri->getTotalSegments();
                    if ($totalSegment > 0) {
                        $uriMain = $uri->getSegment(1);

                        if ($uriMain == "" || $uriMain == "home" || $uriMain == "auth") {
                        } else {
                            return redirect()->to(base_url('auth'));
                        }
                    }
                }
            } catch (\Exception $e) {
                $uri = current_url(true);
                $totalSegment = $uri->getTotalSegments();
                if ($totalSegment > 0) {

                    $uriMain = $uri->getSegment(1);

                    if ($uriMain == "" || $uriMain == "home" || $uriMain == "auth") {
                    } else {
                        // var_dump($e);
                        // var_dump("<br>token salah");
                        // die;
                        return redirect()->to(base_url('auth'));
                    }
                }
            }
        } else {
            $uri = current_url(true);
            $totalSegment = $uri->getTotalSegments();
            if ($totalSegment > 0) {

                $uriMain = $uri->getSegment(1);

                if ($uriMain == "auth") {
                } else {
                    // var_dump("tidak ada token"); die;
                    return redirect()->to(base_url('auth'));
                }
            }
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $jwt = get_cookie('jwt');
        $token_jwt = getenv('token_jwt.default.key');
        if ($jwt) {
            try {
                $decoded = JWT::decode($jwt, new Key($token_jwt, 'HS256'));
                if ($decoded) {
                    $userId = $decoded->id;
                    $level = $decoded->level;
                    $uri = current_url(true);
                    $totalSegment = $uri->getTotalSegments();
                    if ($totalSegment == 0) {

                        $uriMain = $uri->getSegment(1);
                        if ($uriMain === "" || $uriMain === "home" || $uriMain == "portal" || $uriMain == "profil") {
                        } else {
                            // if ($level == 1) { //SuperAdmin
                            //     return redirect()->to(base_url('a/home'));
                            // } else if ($level == 2) { //Admin
                            //     return redirect()->to(base_url('b/home'));
                            // } else if ($level == 3) { //Kecamatan
                            //     return redirect()->to(base_url('c/home'));
                            // } else if ($level == 4) { //SubRayon
                            //     return redirect()->to(base_url('d/home'));
                            // } else if ($level == 5) { //Sekolah
                            //     return redirect()->to(base_url('e/home'));
                            // } else if ($level == 6) { //Kepsek
                            //     return redirect()->to(base_url('f/home'));
                            // } else if ($level == 7) { //PTK
                            //     return redirect()->to(base_url('g/home'));
                            // } else {
                            return redirect()->to(base_url('portal'));
                            // }
                        }
                    } else {
                        return redirect()->to(base_url('portal'));
                        // if ($level == 1) {
                        //     return redirect()->to(base_url('a/home'));
                        // } else if ($level == 2) {
                        //     return redirect()->to(base_url('sp/home'));
                        // } else if ($level == 3) {
                        //     return redirect()->to(base_url('bp/home'));
                        // } else {
                        //     return redirect()->to(base_url('p/home'));
                        // }
                    }
                } else {
                    $uri = current_url(true);
                    $totalSegment = $uri->getTotalSegments();
                    if ($totalSegment > 0) {

                        $uriMain = $uri->getSegment(1);
                        if ($uriMain != 'auth') {
                            return redirect()->to(base_url('auth'));
                        }
                    }
                }
            } catch (\Exception $e) {
                $uri = current_url(true);
                $totalSegment = $uri->getTotalSegments();
                if ($totalSegment > 0) {

                    $uriMain = $uri->getSegment(1);
                    if ($uriMain != 'auth') {
                        return redirect()->to(base_url('auth'));
                    }
                }
            }
        } else {
            $uri = current_url(true);
            $totalSegment = $uri->getTotalSegments();
            if ($totalSegment > 0) {
                $uriMain = $uri->getSegment(1);
                if ($uriMain != 'auth') {
                    return redirect()->to(base_url('auth'));
                }
            }
        }
    }
}
