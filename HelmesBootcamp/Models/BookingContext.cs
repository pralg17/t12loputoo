using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Linq;
using System.Web;

namespace HelmesBootcamp.Models{
    public class BookingContext : DbContext {
        public BookingContext() : base("DefaultConnection") {
      //  Database.ExecuteSqlCommand("DBCC CHECKIDENT('Booking', RESEED, 0)");

        }
        public DbSet<DbBooking> Bookings { get; set; }
        public DbSet<DbGarages> Garages { get; set; }
        public DbSet<DbVehicles> Vihecles { get; set; }
    }
}