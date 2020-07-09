using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.IO;
using System.Linq;
using System.Net;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Configuration;
using TrackEmail.Models;
using TrackEmail.Services;

namespace TrackEmail.Controllers
{
    public class HomeController : Controller
    {
        private readonly string con;
        public HomeController(IConfiguration configuration)
        {
            con = configuration["ConnectionString"];
        }

        public IActionResult Index()
        {
            return View();
        }

        [Route("Track/{rastreio}")]
        public IActionResult Track(string rastreio)
        {
            var db = new DBServices(con);
            var url = rastreio.Split("&");
            var email = url[2].Split("=")[1];
            var titulo = url[1].Split("=")[1];
            var data = DateTime.Now.ToString();
            var nome = url[0].Split("=")[1];

            db.GravarAcesso(email, titulo, data, nome);

            string path = "C:/Users/lucas.andrade/Desktop/Projets/TrackEmail/TrackEmail/Pixel/blank.gif";
            byte[] ImagemByteDados = System.IO.File.ReadAllBytes(path);
            var img = File(ImagemByteDados, "image/png");

            return File(ImagemByteDados, "image/gif", "blank.gif");
        }

        [ResponseCache(Duration = 0, Location = ResponseCacheLocation.None, NoStore = true)]
        public IActionResult Error()
        {
            return View(new ErrorViewModel { RequestId = Activity.Current?.Id ?? HttpContext.TraceIdentifier });
        }
    }
}
