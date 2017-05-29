namespace HelmesBootcamp.Migrations
{
    using System;
    using System.Data.Entity.Migrations;
    
    public partial class DeletedCar : DbMigration
    {
        public override void Up()
        {
            DropColumn("dbo.Booking", "Car");
        }
        
        public override void Down()
        {
            AddColumn("dbo.Booking", "Car", c => c.String(nullable: false));
        }
    }
}
