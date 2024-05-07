<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kairos</title>
    <link rel="icon" type="image/x-icon" href="/Images/Picture1.png">
    </link>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link
        href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
      <link rel="stylesheet" href="style.css">


</head>

<body>
    <style>
#navSearch {
  --background: #ffffff;
  --text-color: #414856;
  --primary-color: #111111;
  --border-radius: 10px;
  --width: 190px;    
  --height: 55px;      
  background: var(--background);
  width: auto;
  height: var(--height);
  position: relative;
  overflow: hidden;
  border-radius: var(--border-radius);
  box-shadow: 0 10px 30px rgba(#414856, .05);
  display: flex;
  justify-content: center;
  align-items: center;
  input[type="text"] {
    position: relative;
    width: var(--height);
    height: var(--height);
    font: 400 16px 'Varela Round', sans-serif;
    color: var(--text-color);
    border: 0;
    box-sizing: border-box;
    outline: none;
    padding: 0 0 0 40px;
    transition: width .6s ease;
    z-index: 10;
    opacity: 0;
    cursor: pointer;
    &:focus {
      z-index: 0;
      opacity: 1;
      width: var(--width);
      ~ .symbol {
        &::before {
          width: 0%;
        }
        &:after {
          clip-path: inset(0% 0% 0% 100%);
          transition: clip-path .04s linear .105s;
        }
        .cloud {
          top: -30px;
          left: -30px;
          transform: translate(0, 0);
          transition: all .6s ease;
        }
        .lens {
          top: 20px;
          left: 15px;
          transform: translate(0, 0);
          fill: var(--primary-color);
          transition: top .5s ease .1s, left .5s ease .1s, fill .3s ease;
        }
      }
    }
  }
  .symbol {
    height: 100%;
    width: 100%;
    position: absolute;
    top: 0;
    z-index: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: transparent;
    &:before {
      content:"";
      position: absolute;
      right: 0;
      width: 100%;
      height: 100%;
      background: var(--primary-color);
      z-index: -1;
      transition: width .6s ease;
    }
    &:after {
      content:"";
      position: absolute;
      top: 21px;
      left: 21px;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      background: var(--primary-color);
      z-index: 1;
      clip-path: inset(0% 0% 0% 0%);
      transition: clip-path .04s linear .225s;
    }
    .cloud,
    .lens {
      position: absolute;
      fill: #fff;
      stroke: currentColor;
      top: 50%;
      left: 50%;
    }
    .cloud {
      width: 35px;
      height: 32px;
      transform: translate(-50%, -60%);
      transition: all .6s ease;
    }
    .lens {
      fill: #fff;
      width: 16px;
      height: 16px;
      z-index: 2;
      top: 24px;
      left: 24px;
      transition: top .3s ease, left .3s ease, fill .2s ease .2s;
    }
  }
}

.NavContainer {
  background: #fff;
  font: 400 16px 'Varela Round', sans-serif;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  .socials {
    position: fixed;
    display: block;
    left: 20px;
    bottom: 20px;
    > Nava {
      display: block;
      width: 30px;
      opacity: var(--opacity, .2);
      transform: scale(var(--scale, .8));
      transition: transform .3s cubic-bezier(0.38,-0.12, 0.24, 1.91);
    }
  }
}
    </style>

    <header class="header shadow z-2">
        <div class="container-fluid" style="background-color: transparent;">
                <!-- <div class="NavContainer">
<div class="search" id="navSearch">
  <input type="text" placeholder="search" />
  <div class="symbol">
    <svg class="cloud">
      <use xlink:href="#cloud" />
    </svg>
    <svg class="lens">
      <use xlink:href="#lens" />
    </svg>
  </div>
</div>
  
<svg xmlns="http://www.w3.org/2000/svg" class="bg-black" style="display: none;">
  <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35 35" id="cloud">
    <path d="M31.714,25.543c3.335-2.17,4.27-6.612,2.084-9.922c-1.247-1.884-3.31-3.077-5.575-3.223h-0.021
	C27.148,6.68,21.624,2.89,15.862,3.931c-3.308,0.597-6.134,2.715-7.618,5.708c-4.763,0.2-8.46,4.194-8.257,8.919
	c0.202,4.726,4.227,8.392,8.991,8.192h4.873h13.934C27.784,26.751,30.252,26.54,31.714,25.543z" />
  </symbol>
  <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" id="lens">
    <path d="M15.656,13.692l-3.257-3.229c2.087-3.079,1.261-7.252-1.845-9.321c-3.106-2.068-7.315-1.25-9.402,1.83
	s-1.261,7.252,1.845,9.32c1.123,0.748,2.446,1.146,3.799,1.142c1.273-0.016,2.515-0.39,3.583-1.076l3.257,3.229
	c0.531,0.541,1.404,0.553,1.95,0.025c0.009-0.008,0.018-0.017,0.026-0.025C16.112,15.059,16.131,14.242,15.656,13.692z M2.845,6.631
	c0.023-2.188,1.832-3.942,4.039-3.918c2.206,0.024,3.976,1.816,3.951,4.004c-0.023,2.171-1.805,3.918-3.995,3.918
	C4.622,10.623,2.833,8.831,2.845,6.631L2.845,6.631z" />
  </symbol>
</svg>
</div>
                </nav>
            </div> -->
            <div class="container-fluid bg-white align-items-right">
            <form class="searchBar" action="">
                <span id="search-txt">Search</span>
                <input type="search" required>
                <i class="fa fa-search"></i>
            </form>
            </div>
        </div>
    </header>
    <header class="upContainer shadow z-2">
        <div class="upContainerProfile">
            <div class="profile">
                <a href="\Profile\editProfile.php">
                    <?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                    <svg class="bg-white" width="40" height="40" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.4"
                            d="M12.1605 10.87C12.0605 10.86 11.9405 10.86 11.8305 10.87C9.45055 10.79 7.56055 8.84 7.56055 6.44C7.56055 3.99 9.54055 2 12.0005 2C14.4505 2 16.4405 3.99 16.4405 6.44C16.4305 8.84 14.5405 10.79 12.1605 10.87Z"
                            stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M7.1607 14.56C4.7407 16.18 4.7407 18.82 7.1607 20.43C9.9107 22.27 14.4207 22.27 17.1707 20.43C19.5907 18.81 19.5907 16.17 17.1707 14.56C14.4307 12.73 9.9207 12.73 7.1607 14.56Z"
                            stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
        </div>
        <div class="upContainerSignOut">
            <div class="signOut">
                <a href="#">
                    <?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                    <svg class="bg-white" width="40" height="40" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M9 4.5H8C5.64298 4.5 4.46447 4.5 3.73223 5.23223C3 5.96447 3 7.14298 3 9.5V14.5C3 16.857 3 18.0355 3.73223 18.7678C4.46447 19.5 5.64298 19.5 8 19.5H9"
                            stroke="#1C274C" stroke-width="1.5" />
                        <path
                            d="M9 6.4764C9 4.18259 9 3.03569 9.70725 2.4087C10.4145 1.78171 11.4955 1.97026 13.6576 2.34736L15.9864 2.75354C18.3809 3.17118 19.5781 3.37999 20.2891 4.25826C21 5.13652 21 6.40672 21 8.94711V15.0529C21 17.5933 21 18.8635 20.2891 19.7417C19.5781 20.62 18.3809 20.8288 15.9864 21.2465L13.6576 21.6526C11.4955 22.0297 10.4145 22.2183 9.70725 21.5913C9 20.9643 9 19.8174 9 17.5236V6.4764Z"
                            stroke="#1C274C" stroke-width="1.5" />
                        <path d="M12 11V13" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                </a>
            </div>
        </div>
    </header>
    <script>
        document.getElementById('searchInput').addEventListener('focus', function () {
            document.querySelector('.container-fluid.bg-white.align-items-right').classList.add('hidden');
        });
    </script>
</body>

</html>