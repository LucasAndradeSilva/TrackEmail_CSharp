using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace TrackEmail.Service
{
    public interface IDBServices
    {
        string GravarAcesso(string email, string titulo, string date, string nome);
    }
}
