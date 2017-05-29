using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace HelmesBootcamp.Models
{
    /// <summary>
    /// We use "Db" before car to indicat that this class is reperesantion of some table in database
    /// </summary>
    [Table("Vehicles")]
    public class DbVehicles
    {
        public DbVehicles()
        {
            this._Bookings = new HashSet<DbBooking>();
        }

        [Key]
        [DatabaseGeneratedAttribute(DatabaseGeneratedOption.Identity)]
        public int Id { get; set; }

        [Required]
        [Display(Name = "Type of Vehicle")]
        public string TypeOfVehicle { get; set; }

        public virtual ICollection<DbBooking> _Bookings { get; set; }
    }
}